<?php
class ProductModel{
private $db;

public function __construct(){
    $this->db=new Database;
}
public function getProducts(){
    $this->db->query("SELECT 
                product.id, 
                product.name, 
                product.quantity, 
                product.price,
                product.type,
                product.category_id,
                category.name AS category_name
            FROM 
                product
            LEFT JOIN 
                category ON  category.id=product.category_id");
    $results=$this->db->resultSet();
    return $results;
}

public function add($data)
{
    $this->db->query("INSERT INTO product (name, quantity, price, type, category_id) VALUES (:name, :quantity, :price, :type, :category_id)");
    $this->db->bind(':name', $data['name']);
    $this->db->bind(':quantity', $data['quantity']);
    $this->db->bind(':price', $data['price']);
    $this->db->bind(':type', $data['type']);
    $this->db->bind(':category_id', $data['category_id']);
    
    // Execute the query
    if ($this->db->execute()) {
        return $this->db->lastInsertId(); // Return the product ID
    }
    return false; // Return false if the query fails
}

// public function add($data)
// {
//     $this->db->query('INSERT INTO product (name, quantity, price, type, category_id) 
//                        VALUES (:name, :quantity, :price, :type, :category_id)');

//     // Bind values
//     $this->db->bind(':name', $data['name']);
//     $this->db->bind(':quantity', $data['quantity']);
//     $this->db->bind(':price', $data['price']);
//     $this->db->bind(':type', $data['type']);
//     $this->db->bind(':category_id', $data['category_id']);
//     // $this->db->bind(':image_path', $data['image_path']);

//     // Execute
//     return $this->db->execute();
// }

// public function add($data){
//     // Prepare the data for insertion, including the image_path
//     $dataToInsert = [
//         'name' => $data['name'],
//         'quantity' => $data['quantity'],
//         'price' => $data['price'],
//         'type' => $data['type'],
//         'category_id' => $data['category']// Add image_path to the data
//     ];

//     // Perform the insert query
//     $result = $this->db->insert('product', $dataToInsert);

//     // Return true if insertion is successful, otherwise false
//     if ($result) {
//         return true;
//     } else {
//         return false;
//     }
// }


public function getProductById($id) {
    $this->db->query("SELECT 
    product.id AS id, 
    product.name AS name, 
    product.quantity AS quantity, 
    product.price AS price, 
    product.type AS type,
    product.category_id, 
    category.name AS category_name
FROM 
    product
LEFT JOIN 
    category ON category.id = product.category_id
WHERE 
    product.id = :id");
$this->db->bind(':id', $id);
$row = $this->db->single();
return $row;

}

    public function getProductsById($id) {
    $conditions = ['category_id' => $id];
    $products = $this->db->select('product', $conditions);
    return $products ? $products : [];
    }


public function update($data)
{
    $this->db->query("UPDATE product SET name = :name, quantity = :quantity, price = :price, type = :type, category_id = :category_id WHERE id = :id");
    $this->db->bind(':name', $data['name']);
    $this->db->bind(':quantity', $data['quantity']);
    $this->db->bind(':price', $data['price']);
    $this->db->bind(':type', $data['type']);
    $this->db->bind(':category_id', $data['category']);
    $this->db->bind(':id', $data['id']);
    return $this->db->execute();
}

public function getImagesByProductId($productId)
{
    $this->db->query("SELECT * FROM product_images WHERE product_id = :product_id");
    $this->db->bind(':product_id', $productId);
    return $this->db->resultSet();
}

public function getImageById($imageId)
{
    $this->db->query("SELECT * FROM product_images WHERE id = :id");
    $this->db->bind(':id', $imageId);
    return $this->db->single();
}

public function deleteImageById($imageId)
{
    $this->db->query("DELETE FROM product_images WHERE id = :id");
    $this->db->bind(':id', $imageId);
    return $this->db->execute();
}






public function delete($id){
    $conditions = ['id' => $id];
    $result=$this->db->delete('product', $conditions);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

public function getProductByType($type) {
    $this->db->query("SELECT 
                product.id, 
                product.name, 
                product.quantity, 
                product.price,
                product.category_id,
                category.name AS category_name
            FROM 
                product
            LEFT JOIN 
                category ON category.id = product.category_id
            WHERE 
                product.type= :type");
    $this->db->bind(':type', $type);
    $results=$this->db->resultSet();
    return $results;
}

public function deleteByCategory($category){
    $conditions = ['category_id' => $category];
    $result=$this->db->delete('product', $conditions);
    if ($result) {
        return true;
    } else {
        return false;
    }
}
public function updateproductQuantityOnPayment($productId,$quantity){
    $this->db->query('UPDATE product SET quantity = quantity - :quantity WHERE id = :product_id');
    $this->db->bind(':quantity',$quantity);
    $this->db->bind('product_id',$productId);
    if($this->db->execute()){
        return true;
    }else{
        return false;
    }
}
public function addImage($productId, $imagePath)
{
    $this->db->query("INSERT INTO product_images (product_id, image_path) VALUES (:product_id, :image_path)");
    $this->db->bind(':product_id', $productId);
    $this->db->bind(':image_path', $imagePath);
    return $this->db->execute();
}

public function getDigitalProductsWithImages() {
    $sql = "
        SELECT 
            p.id, 
            p.name, 
            p.quantity, 
            p.price, 
            p.type, 
            c.name AS category_name,
            (SELECT pi.image_path 
             FROM product_images pi 
             WHERE pi.product_id = p.id 
             LIMIT 1) AS image_path
        FROM 
            product p
        JOIN 
            category c ON p.category_id = c.id
        WHERE 
            p.type = 'Digital'
    ";
    $this->db->query($sql);
    return $this->db->resultSet();
}


public function getPhysicalProductsWithImages() {
    $sql = "
        SELECT 
            p.id, 
            p.name, 
            p.quantity, 
            p.price, 
            p.type, 
            c.name AS category_name,
            (SELECT pi.image_path 
             FROM product_images pi 
             WHERE pi.product_id = p.id 
             LIMIT 1) AS image_path
        FROM 
            product p
        JOIN 
            category c ON p.category_id = c.id
        WHERE 
            p.type = 'Physical'
    ";

    $this->db->query($sql);
    return $this->db->resultSet();
}

public function getPaginatedProductsWithSingleImages($limit, $offset) {
    $sql = "
        SELECT 
            p.id, 
            p.name, 
            p.quantity, 
            p.price, 
            p.type,
            p.category_id,
            c.name AS category_name,
            (SELECT pi.image_path 
             FROM product_images pi 
             WHERE pi.product_id = p.id 
             LIMIT 1) AS image_path
        FROM 
            product p
        JOIN 
            category c ON p.category_id = c.id
        LIMIT :limit OFFSET :offset
    ";
    $this->db->query($sql);
    $this->db->bind(':limit', $limit, PDO::PARAM_INT);
    $this->db->bind(':offset', $offset, PDO::PARAM_INT);
    return $this->db->resultSet();
}

public function getTotalProductsCount() {
    $sql = "SELECT COUNT(*) AS count FROM product";
    $this->db->query($sql);
    return $this->db->single()->count;
}

public function getAllCategories() {
    $query = "SELECT * FROM category";
    $this->db->query($query);
    $this->db->execute();

    return $this->db->resultSet(); // Returns an array of category objects
}



}










