<?php

declare(strict_types=1);

?>
<!DOCTYPE html>
<html>
    <head>
        <?php wp_head(); ?>
    </head>

    <body>
        <h2><?php echo esc_html__('Users Table', 'shudat'); ?></h2>

        <div style="overflow-x:auto;">
            <table>
                <?php
                $tableHead = ['id', 'name', 'username'];
                ?>
                <thead>
                    <tr>
                        <?php foreach ($tableHead as $key => $headValue) : ?>
                            <th> <?php echo esc_html($headValue); ?> </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($args as $key => $user) : ?>
                        <tr data-userid=<?php echo esc_attr($user['id']); ?>>
                            <?php foreach ($tableHead as $key => $headValue) : ?>
                                <td><a class="" href="#"><?php echo esc_html($user[$headValue]); ?></a></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div id="shut_user_details" class=""></div>
    </body>
</html>
<?php
wp_footer();
?>