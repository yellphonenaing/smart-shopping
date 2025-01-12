<div class="container mt-5">
<div class="text-center mb-4">
        <form action="" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Search for products..." required>
            <button type="submit">Search</button>
        </form>
    </div>
    <h1 class="text-center"><?php isset($_GET['search']) ? print("Search result for ".htmlspecialchars($_GET['search'])) : print('Featured Products');?></h1>
    <div class="text-center mb-4">
        <h5>Categories:</h5>
        <?php
        $sql = 'SELECT * FROM categories;';
        $result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)){

        ?>
        <a href="/?cat=<?=$row['id']?>" class="badge badge-info"><?=htmlspecialchars($row['category_name']);?></a>
        <?php }} ?>
    </div>

    <div class="row mt-4" id="product-list">
        <!-- Electronics Category -->
         <?php
         if(isset($_GET['search']) && !empty($_GET['search'])){
            $search = ' AND product_name LIKE "%'.addslashes($_GET['search']).'%";';
        }else{
        $search = '';
        }
         if(isset($_GET['cat']) && !empty($_GET['cat']) && is_numeric($_GET['cat'])){
            $cat_id = $_GET['cat'];
            $sql = "SELECT * FROM products WHERE is_public = 1 AND category_id = '${cat_id}'${search}";
         }else{
         $sql = "SELECT * FROM products WHERE is_public = 1${search}";
         }
         $result = mysqli_query($conn, $sql);
         while ($row = mysqli_fetch_assoc($result)) {
            
         ?>
<div class="col-md-4 mb-4">
    <div class="card">
        <img src="images/<?= htmlspecialchars($row['product_image']); ?>" class="card-img-top" alt="Smartphone">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($row['product_name']); ?></h5>
            <p class="card-text">$<?= htmlspecialchars($row['price']); ?></p>
            <a href="product?id=<?= htmlspecialchars($row['id']); ?>" class="btn btn-primary">View Details</a>
        </div>
    </div>
</div>
<?php } ?>


    </div>
</div>