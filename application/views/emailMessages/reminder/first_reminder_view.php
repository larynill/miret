You are reminded that the following equipment below is due next month:

<ul>
    <?php
    if(count($equipData) > 0)
    {
        foreach($equipData as $k=>$v)
        {
            ?>
            <li><?php echo $k . ' - ' . $v; ?></li>
            <?php
        }
    }
    ?>
</ul>

If you want request a quote, then click the button below.
<br>

<button style="padding: 8px 10px; background-color: #35aa47; cursor: pointer; color:#fff; border: none">
    <a style="text-decoration: none; outline: none; color: #fff;" href="<?php echo base_url() . 'request/quote/'.$trackID.'/' . $this->encryption->encode($clientID); ?>">
        Request Quote
    </a>
</button>