<?php
require('top.inc.php');

if (isset($_SESSION['ADMIN_LOGIN'])) {
    $revenue=mysqli_fetch_assoc(mysqli_query($con,"SELECT SUM(`order`.total_price) AS revenue FROM `order` WHERE `order`.`payment_status`!='Pending' AND `order`.order_status!='4'"));
    $sales=mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(*) AS row_count FROM `order` WHERE order_status!='4'"));
    $queries=mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(*) AS row_count FROM contact_us"));
    $clients=mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(*) AS row_count FROM users"));
    $orderTable=mysqli_query($con,"SELECT users.pfp, users.name, `order`.id AS order_id, `order`.order_status, order_detail.product_id, order_detail.qty FROM users RIGHT JOIN `order` ON `order`.user_id=users.id RIGHT JOIN order_detail ON order_detail.order_id=`order`.id ORDER BY order_detail.id DESC");
}
?>

<!-- Content -->
        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
                <!-- Widgets  -->
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-1">
                                        <i class="pe-7s-cash"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text">$<span class="count"><?php echo $revenue['revenue']?></span></div>
                                            <div class="stat-heading">Revenue</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-2">
                                        <i class="pe-7s-cart"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text"><span class="count"><?php echo $sales['row_count']?></span></div>
                                            <div class="stat-heading">Sales</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-3">
                                        <i class="pe-7s-comment"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text"><span class="count"><?php echo $queries['row_count']?></span></div>
                                            <div class="stat-heading">Customer Queries</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-4">
                                        <i class="pe-7s-users"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text"><span class="count"><?php echo $clients['row_count']?></span></div>
                                            <div class="stat-heading">Clients</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Widgets -->
                <!-- Orders -->
                <div class="orders">
                    <div class="row">
                        <div class="col-xl-8">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="box-title">Orders </h4>
                                </div>
                                <div class="card-body--">
                                    <div class="table-stats order-table ov-h">
                                        <table class="table ">
                                            <thead>
                                                <tr>
                                                    <th class="serial">#</th>
                                                    <th class="avatar">Avatar</th>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Product</th>
                                                    <th>Quantity</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $index=1;
                                            while($row = mysqli_fetch_assoc($orderTable)) { ?>
                                                <tr>
                                                    <td class="serial"><?php echo $index."."?></td>
                                                    <td class="avatar">
                                                        <div class="round-img">
                                                            <?php
                                                            if (empty($row['pfp'])) {
                                                                echo '<img class="rounded-circle" src="images/blank-pfp.png" alt="profile">';
                                                            } else {
                                                                echo '<img class="rounded-circle" src="'.USER_IMAGE_SITE_PATH . $row['pfp'].'" alt="">';
                                                            }
                                                            ?>
                                                        </div>
                                                    </td>
                                                    <td>#<?php echo $row['order_id']?></td>
                                                    <td><span class="name"><?php echo $row['name']?></span></td>
                                                    <td>
                                                        <span class="product">
                                                            <?php
                                                            $prod=mysqli_fetch_assoc(mysqli_query($con,"SELECT product.name FROM product WHERE product.id='".$row['product_id']."'"));
                                                            if (!empty($prod)) {
                                                                echo $prod['name'];
                                                            } else {
                                                                echo "";
                                                            }
                                                            ?>
                                                        </span>
                                                    </td>
                                                    <td><span class="count"><?php echo $row['qty']?></span></td>
                                                    <td><?php
                                                        $orderStat=mysqli_fetch_assoc(mysqli_query($con,"SELECT order_status.name FROM order_status WHERE order_status.id='".$row['order_status']."'")); 
                                                        if ($row['order_status']==3) { ?>
                                                            <span class="badge badge-primary"> <?php
                                                        } elseif ($row['order_status']==4) {?>
                                                            <span class="badge badge-danger"> <?php
                                                        } else {?>
                                                        <span class="badge badge-<?php echo strtolower($orderStat['name'])?>">
                                                        <?php }
                                                        echo $orderStat['name'];
                                                        ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php
                                            $index++;
                                            } ?>
                                            </tbody>
                                        </table>
                                    </div> <!-- /.table-stats -->
                                </div>
                            </div> <!-- /.card -->
                        </div>  <!-- /.col-lg-8 -->

                        <div class="col-xl-4">
                            <div class="row">
                                <div class="col-lg-6 col-xl-12">
                                    <div class="card br-0">
                                        <div class="card-body">
                                            <div class="chart-container ov-h">
                                                <div id="flotPie1" class="float-chart"></div>
                                            </div>
                                        </div>
                                    </div><!-- /.card -->
                                </div>

                                <div class="col-lg-6 col-xl-12">
                                    <div class="card bg-flat-color-3  ">
                                        <div class="card-body">
                                            <h4 class="card-title m-0  white-color ">August 2018</h4>
                                        </div>
                                         <div class="card-body">
                                             <div id="flotLine5" class="flot-line"></div>
                                         </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- /.col-md-4 -->
                    </div>
                </div>
                <!-- /.orders -->
            </div>
            <!-- .animated -->
        </div>
        <!-- /.content -->
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    
    <!--  Chart js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.3/dist/Chart.bundle.min.js"></script>

    <!--Chartist Chart-->
    <script src="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartist-plugin-legend@0.6.2/chartist-plugin-legend.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery.flot@0.8.3/jquery.flot.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flot-pie@1.0.0/src/jquery.flot.pie.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flot-spline@0.0.1/js/jquery.flot.spline.min.js"></script>

    <!--Local Stuff-->
    <script>
        jQuery(document).ready(function($) {
            "use strict";

            // Pie chart flotPie1
            var piedata = [
                { label: "Desktop visits", data: [[1,32]], color: '#5c6bc0'},
                { label: "Tab visits", data: [[1,33]], color: '#ef5350'},
                { label: "Mobile visits", data: [[1,35]], color: '#66bb6a'}
            ];

            $.plot('#flotPie1', piedata, {
                series: {
                    pie: {
                        show: true,
                        radius: 1,
                        innerRadius: 0.65,
                        label: {
                            show: true,
                            radius: 2/3,
                            threshold: 1
                        },
                        stroke: {
                            width: 0
                        }
                    }
                },
                grid: {
                    hoverable: true,
                    clickable: true
                }
            });
            // Pie chart flotPie1  End
            
            // Line Chart  #flotLine5
            var newCust = [[0, 3], [1, 5], [2,4], [3, 7], [4, 9], [5, 3], [6, 6], [7, 4], [8, 10]];

            var plot = $.plot($('#flotLine5'),[{
                data: newCust,
                label: 'New Data Flow',
                color: '#fff'
            }],
            {
                series: {
                    lines: {
                        show: true,
                        lineColor: '#fff',
                        lineWidth: 2
                    },
                    points: {
                        show: true,
                        fill: true,
                        fillColor: "#ffffff",
                        symbol: "circle",
                        radius: 3
                    },
                    shadowSize: 0
                },
                points: {
                    show: true,
                },
                legend: {
                    show: false
                },
                grid: {
                    show: false
                }
            });
            // Line Chart  #flotLine5 End
        });
    </script>
<?php
require('footer.inc.php');
?>