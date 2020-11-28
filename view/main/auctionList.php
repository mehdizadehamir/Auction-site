<?php
include_once __DIR__."/../../model/auctions/auctions.php";

$auctions = new Auctions($__connection);

$_filter_by = (!empty($_GET['f'])) ? $_GET['f'] : 'all';
$_order_by = (!empty($_GET['o'])) ? $_GET['o'] : 'latest';
?>

<div class="px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center col-6">
    <div class="row mb-3">
        <div class="col-3 text-left">
            <label for="auctions-order-select" class="col-form-label">Order</label>
            <select id="auctions-order-select" class="form-control custom-select">
                <option value="latest" <?php if($_order_by == 'latest') echo 'selected'; ?>>Latest</option>
                <option value="price-h" <?php if($_order_by == 'price-h') echo 'selected'; ?>>Price highest</option>
                <option value="price-l" <?php if($_order_by == 'price-l') echo 'selected'; ?>>Price lowest</option>
                <option value="bids-h" <?php if($_order_by == 'bids-h') echo 'selected'; ?>>Bids highest</option>
                <option value="bids-l" <?php if($_order_by == 'bids-l') echo 'selected'; ?>>Bids lowest</option>
            </select>
        </div>
        <div class="col-3 text-left d-none">
            <label for="auctions-filter-select" class="col-form-label">Filter</label>
            <select id="auctions-filter-select" class="form-control custom-select">
                <option value="all" <?php if($_filter_by == 'all') echo 'selected'; ?>>All</option>
                <option value="rtb" <?php if($_filter_by == 'rtb') echo 'selected'; ?>>Ready to bids</option>
                <option value="to" <?php if($_filter_by == 'to') echo 'selected'; ?>>TimeOvers</option>
            </select>
        </div>
    </div>
    <?
    $totalAuctions = 0;
    $myAuctions = $auctions->lists($_filter_by,$_order_by);
    if($myAuctions != null):
        ?>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Bids count</th>
                    <th>Highest offer</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <? while($row=mysqli_fetch_array($myAuctions)): ?>
                    <?
                    $totalAuctions = $row['totalRows'];
                    $regDate = $row['regDate'];
                    ?>
                    <tr>
                        <td><?=$row['name'];?></td>
                        <td><?=$row['price'];?></td>
                        <td>
                            <?
                            $status_s = $row['soldStatus'];
                            $status_a = $row['isActive'];
                            if($status_s == 2){
                                if(($status_a == 0) || ($regDate < time())){
                                    echo '<span class="p-2 alert alert-warning">TimeOver</span>';
                                }else{
                                    echo '<span class="p-2 alert alert-success">Active</span>';
                                }
                            }else{
                                echo '<span class="p-2 alert alert-success">Sold</span>';
                            }
                            ?>
                        </td>
                        <td><?=$row['bidsCount'];?></td>
                        <td><?=$row['highestOffer'];?></td>
                        <td>
                            <a href="auction.php?id=<?=$row['id'];?>" class="btn btn-success pt-1 pb-1" style="font-size: 14px;">
                                <span>Make bids</span>
                                &nbsp;
                                <span class="fa fa-gavel"></span>
                            </a>
                        </td>
                    </tr>
                <? endwhile; ?>
                </tbody>
            </table>

            <?
            $pageCount = $totalAuctions / $__TABLE_MAX_COUNT_PER_PAGE;
            $pageCountInt = intval($pageCount);
            $pageCountExact = 0;
            if($pageCount > $pageCountInt){
                $pageCountExact = $pageCountInt + 1;
            }else{
                $pageCountExact = $pageCountInt;
            }

            if($pageCount > 1):
                $s=intval(get('s'));
                if($s == 0){
                    $s = 1;
                }
                ?>
                <div class="dropdown-divider mb-3"></div>
                <nav>
                    <ul class="pagination pagination">
                        <? for($i=0;$i<$pageCountExact;$i++):?>
                            <? if(($i+1) == $s): ?>
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link"><?=($i+1);?></span>
                                </li>
                            <? else: ?>
                                <li class="page-item"><a class="page-link" href="index.php<?=(!empty($_SERVER['QUERY_STRING'])) ? '&' : '?'; ?>s=<?=($i+1);?>"><?=($i+1);?></a></li>
                            <? endif; ?>
                        <? endfor; ?>
                    </ul>
                </nav>
            <? endif; ?>

        </div>
    <? else: ?>
        <div class="dropdown-divider"></div>
        <p class="mt-5 text-center" style="font-weight: 100;font-size: 18px; color: #AAAAAA;">There is no auction</p>
    <? endif; ?>
</div>


<script>
    var __orderByP  = '<?=$_order_by;?>';
    var __filterByP = '<?=$_filter_by;?>';

    $(document).ready(function () {

        $('#auctions-order-select').change(function () {
           window.location = 'index.php?o='+ $(this).val() +'&f='+ __filterByP;
        });

        $('#auctions-filter-select').change(function () {
            window.location = 'index.php?o='+ __orderByP +'&f='+ $(this).val();
        });

    });
</script>