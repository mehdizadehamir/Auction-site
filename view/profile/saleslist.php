<?php
include_once "model/auctions/auctions.php";

$auctions = new Auctions($__connection);

//deleteDirectory();
?>
<div class="container">
    <div class="row mt-3">
        <div class="col-12 col-md-11 mx-auto text-left" id="warnIdSalesList"></div>
    </div>
    <div class="row pt-2">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <h3 class="mb-4">Your auction list</h3>
                    <?
                        $totalAuctions = 0;
                        $myAuctions = $auctions->select($user_login_data['id']);
                        if($myAuctions != null):
                    ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Bids count</th>
                                        <th>Highest offer</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? while($row=mysqli_fetch_array($myAuctions)): ?>
                                        <?
                                            $totalAuctions = $row['totalRows'];
                                            $regDate = $row['regDate'];
                                        ?>
                                        <tr>
                                            <td><?=$row['id'];?></td>
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
                                                    <li class="page-item"><a class="page-link" href="profile.php?p=SalesList&s=<?=($i+1);?>"><?=($i+1);?></a></li>
                                                <? endif; ?>
                                            <? endfor; ?>
                                        </ul>
                                    </nav>
                                <? endif; ?>

                            </div>
                    <? else: ?>
                            <div class="dropdown-divider"></div>
                            <p class="mt-5 text-center" style="font-weight: 100;font-size: 18px; color: #AAAAAA;">There is no auction, <br><a href="profile.php?p=sales" style="font-size: 16px;color:#000000;text-decoration: underline;">Click here</a> to create new Auction!</p>
                    <? endif; ?>

                </div>
                <div class="col-12 col-md-5 mx-auto">
                    <div id="imgPlaceHolder" class="imgPlaceHolder d-none">
                        <img src="" style="width: 100%; height: 100%;border: none;box-shadow: none;" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
