<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'fastMultiplication.php';
    $num1 = $_POST['num1'] ?? null;
    $num2 = $_POST['num2'] ?? null;

    if ('' === $num1 || '' === $num2) {
        echo json_encode(['error' => true, 'message' => 'Ввод значения для умножения!']);
        exit;
    }

    $fastMultiplication = new fastMultiplication();
    $result = $fastMultiplication->multiplication($num1, $num2);

    echo json_encode(['error' => false, 'result' => $result]);
    exit;
}
?>

<form>
    <div class="error"></div>
    <input name="num1" type="text" /> * <input name="num2" type="text" /> = <span class="result"></span><br>
    <button type="submit">
        Умножение
    </button>
</form>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script type="application/javascript">
    jQuery(document).ready(function () {
        var form = jQuery('form');
        form.on('submit', function () {
            var
                num1 = jQuery(this).find('input[name=num1]').val(),
                num2 = jQuery(this).find('input[name=num2]').val(),
                result = jQuery(this).find('span.result'),
                error = jQuery(this).find('div.error');
            error.html('');
            result.html('');

            jQuery.ajax({
                url: '',
                data: {
                    num1: num1,
                    num2: num2
                },
                type: 'post',
                dataType : "json"
            }).done(function (json) {
                if (json.error) {
                    error.html(json.message);
                    return false;
                }
                result.html(json.result);
                return true;
            });

            return false;
        })
    });
</script>