<?php

/**
 * The Template for displaying users' data as html table. This template can be
 * displayed at yourHomeLink/users-table .
 *
 * This template can be overridden by copying it to yourtheme/ShowTable.php.
 * @version     1.0.0
 */

declare(strict_types=1);

?>
<!DOCTYPE html>
<html>
    <head>
        <?php wp_head(); ?>
    </head>

    <body>
        <!-- Top navigation -->
        <div class="topnav">
            <a href="<?php echo esc_url(get_home_url()); ?>" class="active">Home</a>
        </div>
        <!-- End Top navigation -->

        <!-- Table -->
        <h2><?php echo esc_html__('Users Table', 'shudat'); ?></h2>

        <div style="overflow-x:auto;">
            <table>
                <?php
                $tableHead = [ 'id', 'name', 'username' ];
                ?>
                <thead>
                    <tr>
                        <?php foreach ($tableHead as $key => $headValue) : ?>
                            <th> <?php echo esc_html($headValue); ?> </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // $args is equal to $usersList, sent by `load_template` function. phpcs is disabled for this line to avoid warning.
                    // phpcs:disable VariableAnalysis.CodeAnalysis.VariableAnalysis
                    foreach ($args as $key => $user) :
                    // phpcs:enable VariableAnalysis.CodeAnalysis.VariableAnalysis
                        ?>
                        <tr data-userid=<?php echo esc_attr($user['id']); ?>>
                            <?php foreach ($tableHead as $key => $headValue) : ?>
                                <td>
                                    <a href="#">
                                        <?php echo esc_html($user[ $headValue ]); ?>
                                    </a>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- End Table -->
        <div id="shut_user_details" class=""></div>
    </body>
</html>
<?php
wp_footer();
?>
