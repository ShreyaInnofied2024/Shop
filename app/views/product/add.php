<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="index.js"></script>
    <script src="https://kit.fontawesome.com/155c5ab2ca.js" crossorigin="anonymous"></script>
</head>

<body>

<header>
<?php require APPROOT . '/views/inc/header.php'; ?>
</header>

<section id="login" class="d-flex justify-content-center align-items-start py-5" style="min-height: 100vh;">
    <div class="login-container bg-white p-4 rounded shadow-sm w-100" style="max-width: 500px;">
        <h2 class="text-center mb-4" style="color: #a27053;">Add Product</h2>
        <form id="product" action="<?php echo URLROOT; ?>/productController/add" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <input type="text" name="name" id="name" class="form-control <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" 
                    value="<?php echo $data['name']; ?>" placeholder="Enter product name">
                <div class="invalid-feedback"><?php echo $data['name_err']; ?></div>
            </div>
            
            <div class="mb-3">
                <input type="text" name="quantity" id="quantity" class="form-control <?php echo (!empty($data['quantity_err'])) ? 'is-invalid' : ''; ?>" 
                    value="<?php echo $data['quantity']; ?>" placeholder="Enter quantity">
                <div class="invalid-feedback"><?php echo $data['quantity_err']; ?></div>
            </div>

            <div class="mb-3">
                <input type="text" name="price" id="price" class="form-control <?php echo (!empty($data['price_err'])) ? 'is-invalid' : ''; ?>" 
                    value="<?php echo $data['price']; ?>" placeholder="Enter price">
                <div class="invalid-feedback"><?php echo $data['price_err']; ?></div>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Product Image</label>
                <input type="file" name="images[]" id="images" class="form-control" multiple onchange="previewImages()">
                <div id="image-preview" class="mt-3"></div>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Product Type</label>
                <select name="type" id="type" class="form-select <?php echo (!empty($data['type_err'])) ? 'is-invalid' : ''; ?>">
                    <option value="Physical" <?php echo ($data['type'] == 'Physical') ? 'selected' : ''; ?>>Physical</option>
                    <option value="Digital" <?php echo ($data['type'] == 'Digital') ? 'selected' : ''; ?>>Digital</option>
                </select>
                <div class="invalid-feedback"><?php echo $data['type_err']; ?></div>
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select name="category_id" id="category" class="form-select <?php echo (!empty($data['category_err'])) ? 'is-invalid' : ''; ?>">
                    <?php foreach ($data['categories'] as $category): ?>
                        <option value="<?php echo $category->id; ?>" <?php echo ($data['category'] == $category->id) ? 'selected' : ''; ?>>
                            <?php echo $category->name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback"><?php echo $data['category_err']; ?></div>
            </div>

            <button type="submit" class="btn " style="background-color: #a27053;color: white;">Submit</button>
        </form>

        <div class="mt-3 text-center">
            <a href="<?php echo URLROOT; ?>/productController" class="text-decoration-none text-secondary">Go Back</a>
        </div>
    </div>
</section>

<script>
    let selectedFiles = [];  // Track the selected files in an array

    function previewImages() {
        const previewContainer = document.getElementById('image-preview');
        previewContainer.innerHTML = ''; // Clear previous previews

        const files = document.getElementById('images').files;

        // Store the selected files in the array
        selectedFiles = Array.from(files);

        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();

            reader.onload = function(e) {
                const imageWrapper = document.createElement('div');
                imageWrapper.classList.add('text-center', 'mb-3');

                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-thumbnail');
                img.style.width = '150px'; // Adjust as needed
                imageWrapper.appendChild(img);

                // Create Remove Button
                const removeBtn = document.createElement('button');
                removeBtn.textContent = 'Remove';
                removeBtn.classList.add('btn', 'btn-danger', 'btn-sm', 'mt-2');

                // Add event listener to remove the image when clicked
                removeBtn.onclick = function() {
                    // Remove the image preview
                    previewContainer.removeChild(imageWrapper);
                    // Remove the file from the selectedFiles array
                    selectedFiles.splice(index, 1);
                    // Re-assign the updated files array to the file input
                    updateFileInput();
                };

                imageWrapper.appendChild(removeBtn);
                previewContainer.appendChild(imageWrapper);
            };

            reader.readAsDataURL(file);
        });
    }

    function updateFileInput() {
        const fileInput = document.getElementById('images');

        // Create a new DataTransfer object to update the file input
        const dataTransfer = new DataTransfer();
        
        // Add the remaining selected files to the DataTransfer object
        selectedFiles.forEach(file => {
            dataTransfer.items.add(file);
        });

        // Update the file input with the new FileList
        fileInput.files = dataTransfer.files;

        // Optional: Update the file count displayed in the input element
        if (fileInput.files.length === 0) {
            fileInput.setAttribute('title', 'No files selected');
        } else {
            fileInput.setAttribute('title', fileInput.files.length + ' files selected');
        }
    }
</script>

</body>
</html>
