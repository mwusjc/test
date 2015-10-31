
</header>

<main class='shopping-cart'>

    <div class='row'>
        <div class='col-sm-12'>
            <h1>Shopping List</h1>
        </div>
    </div>
    <div class='row'>
    <div class='col-sm-12 shoppingListWrapper'>  
        <h2>You currently have nothing in your list.</h2>
    </div>
    </div>

    <div class='row'>
        <div class='col-sm-6 col-sm-push-6'>
            <div class='controls'>
                <span href='#' class='btn lightgrey clearList'>Clear List</span>
                <a href='javascript:window.print()' class='btn green printList'>Print List</a>        
            </div>
        </div>
    </div>
</main>
<script type="text/javascript">
$(document).ready(function(){
    sl.populateShoppingList();
    $(".clearList").click(function(){
        sl.clearProducts();
    });
});
</script>