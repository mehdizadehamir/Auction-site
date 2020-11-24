<?php
include_once __DIR__."/../../model/purchases/purchases.php";

$purchases = new Purchases($__connection);
?>
<div class="container">
    <div class="row mt-3">
        <div class="col-12 col-md-11 mx-auto text-left" id="warnIdSalesList"></div>
    </div>
    <div class="row pt-2">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <h3 class="mb-4">Your purchases list</h3>
                    <?
                    $totalAuctions = 0;
                    $myPurchases = $purchases->select($user_login_data['id']);
                    if($myPurchases != null):
                        ?>
                        <div class="table-responsive customTable">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th width="10%">#</th>
                                    <th width="20%">Name</th>
                                    <th width="30%">Price</th>
                                    <th width="40%" class="text-right">Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <? while($row=mysqli_fetch_array($myPurchases)): ?>
                                    <?
                                    $totalAuctions = $row['totalRows'];
                                    $regDate = $row['regDate'];
                                    ?>
                                    <tr <?= ($row['isSeen'] == 0) ? 'class="active"' : ''; ?>>
                                        <td><?=$row['id'];?></td>
                                        <td><?=$row['name'];?></td>
                                        <td><?=$row['price'];?></td>
                                        <td class="text-right"><?=$row['regDate'];?></td>
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
                                                <li class="page-item"><a class="page-link" href="profile.php?p=Purchases&s=<?=($i+1);?>"><?=($i+1);?></a></li>
                                            <? endif; ?>
                                        <? endfor; ?>
                                    </ul>
                                </nav>
                            <? endif; ?>

                        </div>
                    <? else: ?>
                        <div class="dropdown-divider"></div>
                        <p class="mt-5 text-center" style="font-weight: 100;font-size: 18px; color: #AAAAAA;">You have not purchased anything yet!</p>
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
