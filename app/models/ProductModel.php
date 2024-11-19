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

public function add($data){
    // Prepare the data for insertion, including the image_path
    $dataToInsert = [
        'name' => $data['name'],
        'quantity' => $data['quantity'],
        'price' => $data['price'],
        'type' => $data['type'],
        'category_id' => $data['category'],
        'image_path' => $data['image_path'] // Add image_path to the data
    ];

    // Perform the insert query
    $result = $this->db->insert('product', $dataToInsert);

    // Return true if insertion is successful, otherwise false
    if ($result) {
        return true;
    } else {
        return false;
    }
}


public function getProductById($id) {
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




public function edit($data){
    $data = [
        'id'=>$data['id'],
        'name'=>$data['name'],
        'quantity'=>$data['quantity'],
        'price' =>$data['price'],
            'type'=>$data['type'],
            'category_id'=>$data['category'],
    ];
    $where = 'id = :id';
    $result = $this->db->update('product', $data, $where);
    if ($result) {
       return true;
    } else {
        return false;
    }
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
}