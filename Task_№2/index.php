<?php
require  'Tree.php';

$tree = new Tree();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nodeId = $_POST['nodeId'] ?? null;
    $parentId = $_POST['parentId'] ?? null;

    if ('' === $nodeId || '' === $parentId) {
        echo json_encode(['error' => true, 'message' => 'Ошибка при передачи данных!']);
        exit;
    }
    $tree->updateNode($nodeId, $parentId);
    echo json_encode(['error' => false]);
    exit;
}

$nodes = $tree->getTree();

function printTree(array $tree, int $parentId) {
    echo '<ul class="droptrue" data-parent-id="'.$parentId.'">'.PHP_EOL;
    foreach ($tree as $node) {
        echo '<li data-element-id="'.$node['id'].'" class="draggable"> '.PHP_EOL;
        echo $node['name'].PHP_EOL;

        if (!empty($node['child'])) {
            printTree($node['child'], $node['id']);
        } else {
            echo '<ul class="droptrue" data-parent-id="'.$node['id'].'" style="min-height: 10px;"></ul>';
        }
        echo '</li>'.PHP_EOL;
    }
    echo '</ul>'.PHP_EOL;
}
?>
<!doctype html>
<html lang="ru_RU">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style type="text/css">
        body {
            font-family: Courier , Helvetica, cursive;
        }
        table {
            font-size: 1em;
        }
    </style>
    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        $( function() {
            $( "ul.droptrue" ).sortable({
                connectWith: "ul",
                stop: function( event, ui ) {
                    var
                        elementId = ui.item.data('elementId'),
                        parentId = ui.item.parent('ul').data('parentId'),
                        errorDiv = $('.errors');

                    errorDiv.html('');
                    $.ajax({
                        url: '',
                        data: {
                            nodeId: elementId,
                            parentId: parentId
                        },
                        type: 'post',
                        dataType : "json"
                    }).done(function (json) {
                        if (json.error) {
                            errorDiv.html(json.message);
                            return false;
                        }
                        return true;
                    });
                }
            });

        } );
    </script>
</head>

<body>
<div class="errors"></div>
<?php printTree($nodes, 0); ?>
</body>
</html>