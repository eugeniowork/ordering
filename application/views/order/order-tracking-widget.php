<div id="tracking">
    <!-- <div class="text-center tracking-status-current">
       <p class="tracking-status text-tight">in transit</p>
    </div> -->

    <div class="tracking-list">
        <?php foreach($order_logs as $key => $log): ?>
            <?php
                //IF FIRST ELEMENT OF ARRAY - MEANING THIS WILL BE THE HIGHLIGHTED SECTION
                $class_name = $key == 0? 'current': 'previous';
            ?>
            <div class="tracking-item">
                <div class="tracking-icon tracking-status-<?= $class_name; ?>"><i class="fa fa-check"></i></div>
                <div class="tracking-content tracking-content-current">
                    <span class="tracking-content-title"><?= $log->title; ?></span>
                    <span class="tracking-content-description"><?= $log->description; ?></span>
                    <span class="tracking-content-name"><?= $log->firstname." ".$log->lastname; ?></span>
                    <span class="tracking-content-date"><?= date('F d, Y h:i A', strtotime($log->created_date)); ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>