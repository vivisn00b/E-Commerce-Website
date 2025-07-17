function manage_cart_update(pid, type, size_id, color_id, pro_qty) {
  jQuery("#cid").val(color_id);
  jQuery("#sid").val(size_id);
  jQuery("#qty").val(pro_qty);
  manage_cart(pid, type);
}

function manage_cart(pid, type, is_color, is_size) {
  let is_error = "";
  let qty = jQuery("#qty").val();
  let cid = jQuery("#cid").val();
  let sid = jQuery("#sid").val();
  if (type == "add") {
    if (is_color != 0 && cid == "") {
      is_error = "yes";
      alert("Please select a color!");
    }
    if (is_size != 0 && sid == "" && is_error == "") {
      is_error = "yes";
      alert("Please select a size!");
    }
  }
  if (is_error == "") {
    jQuery.ajax({
      url: "manage_cart.php",
      type: "post",
      data: `pid=${pid}&qty=${qty}&type=${type}&cid=${cid}&sid=${sid}`,
      success: function (result) {
        if (type == "remove") {
          window.location.href = window.location.href;
        }
        if (result == "not_avaliable") {
          alert("Quantity not avaliable");
        } else {
          jQuery(".item-number1").html(result);
        }
      },
    });
  }
}

function wishlist_manage(pid, type) {
  jQuery.ajax({
    url: "wishlist_manage.php",
    type: "post",
    data: "pid=" + pid + "&type=" + type,
    success: function (result) {
      if (result == "not_login") {
        window.location.href = "login.php";
      } else {
        jQuery(".item-number2").html(result);
      }
    },
  });
}

function loadAttr(c_id, pid, type) {
  jQuery.ajax({
    url: "load_attr.php",
    type: "post",
    data: "c_id=" + c_id + "&pid=" + pid + "&type=" + type,
    success: function (result) {
      jQuery("#cid").val(c_id);
      jQuery("#size_attr").html(result);
    },
  });
}

function showQty(p_id) {
  let cid = jQuery("#cid").val();
  if (cid !== "") {
    let sid = jQuery(":radio[name=size]:checked").val();
    // if (!sid) {
    //   sid = jQuery(":radio[name=size]:radio:checked").val();
    // }
    jQuery("#sid").val(sid);
    getProductQuantity(p_id);
    discount(p_id, sid, cid);
    getPrice(p_id, sid, cid);
    jQuery(".qty-control").removeAttr("hidden");
  }
}

function getProductQuantity(proId) {
  var colorId = jQuery("#cid").val();
  var sizeId = jQuery("#sid").val();

  if (colorId !== "" && sizeId !== "") {
    jQuery.ajax({
      type: "POST",
      url: "get_quantity.php",
      data: "pro_id=" + proId + "&color_id=" + colorId + "&size_id=" + sizeId,
      success: function (response) {
        jQuery("#qty_res").val(response);
        checkProQty(response, proId);
        qtyManipulation(response);
      },
    });
  }
}

function checkProQty(qty, p_id) {
  jQuery.ajax({
    type: "POST",
    url: "check_quantity.php",
    data: "qty=" + qty + "&pro_id=" + p_id,
    success: function (response) {
      jQuery("#qty_avail").html(response);
      if (response.trim() === "Out of Stock") {
        //document.getElementById("addToCart").setAttribute("disabled", true);
        jQuery("#addToCart").prop("disabled", true);
        jQuery("#qty").prop("disabled", true);
        jQuery(".minus").prop("disabled", true);
        jQuery(".plus").prop("disabled", true);
      } else {
        jQuery("#addToCart").prop("disabled", false);
        jQuery("#qty").prop("disabled", false);
        jQuery(".minus").prop("disabled", false);
        jQuery(".plus").prop("disabled", false);
      }
    },
  });
}

function discount(proId, sId, cId) {
  jQuery.ajax({
    type: "POST",
    url: "product_discount.php",
    data: "pro_id=" + proId + "&size_id=" + sId + "&color_id=" + cId,
    success: function (response) {
      jQuery(".discount").html(response);
    },
  });
}

function getPrice(proId, sId, cId) {
  jQuery.ajax({
    type: "POST",
    url: "product_price.php",
    data: "pro_id=" + proId + "&size_id=" + sId + "&color_id=" + cId,
    success: function (response) {
      jQuery("#pro-price").html(response);
    },
  });
}

function qtyManipulation(proQty) {
  let quantityInput = document.getElementById("qty");
  let plusButton = document.querySelector(".plus");
  let minusButton = document.querySelector(".minus");
  let pendingQty = proQty;

  quantityInput.value = 1;

  plusButton.addEventListener("click", function () {
    let currentQuantity = parseInt(quantityInput.value);
    if (currentQuantity < pendingQty) {
      quantityInput.value = currentQuantity + 1;
    }
  });

  minusButton.addEventListener("click", function () {
    if (quantityInput.value > 1) {
      quantityInput.value = parseInt(quantityInput.value) - 1;
    }
  });
}

function showQuantity(cid, pid, type) {
  jQuery.ajax({
    url: "load_attr.php",
    type: "post",
    data: "c_id=" + cid + "&pid=" + pid + "&type=" + type,
    dataType: "json",
    success: function (result) {
      let price = result.price;
      let mrp = result.mrp;
      let quantity = result.quantity;
      let s_id = result.sizeId;
      jQuery("#cid").val(cid);
      jQuery("#sid").val(s_id);
      jQuery(".qty-control").removeAttr("hidden");
      console.log(
        `Price: ${price}, MRP: ${mrp}, Quantity: ${quantity}, Size id: ${s_id}`
      );
      getProductQuantity(pid);
      discount(pid, s_id, cid);
      getPrice(pid, s_id, cid);
    },
  });
}
