<?php

declare(strict_types=1);

?>
<!DOCTYPE html>
<html>
<head>
<?php wp_head(); ?>
</head>
<body>

<h2>HTML Table</h2>

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
                    <td><a class="" href="#"><?php echo esc_html($user[ $headValue ]); ?></a></td>
                <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
</table>

</body>
</html>
<?php
wp_footer();
?>


