<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Image Selector</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            background-color: #f0f0f0;
        }
        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }
        .gallery img {
            cursor: pointer;
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 2px solid transparent;
            transition: border-color 0.3s;
        }
        .gallery img.selected {
            border-color: blue;
        }
        button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Select an Image</h1>
    <div class="gallery">
        <?php
        $imageDir = "C:/xampp/htdocs/website/images";
        $images = glob($imageDir . "/*.jpg");

        foreach ($images as $image) {
            $imageName = basename($image);
            echo "<img src='images/$imageName' data-name='$imageName' alt='$imageName'>";
        }
        ?>
    </div>
    <button id="saveButton">Save</button>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const images = document.querySelectorAll('.gallery img');
            let selectedImage = null;

            images.forEach(img => {
                img.addEventListener('click', () => {
                    images.forEach(i => i.classList.remove('selected'));
                    img.classList.add('selected');
                    selectedImage = img.dataset.name;
                });
            });

            document.getElementById('saveButton').addEventListener('click', () => {
                if (selectedImage) {
                    fetch('save_image.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ selectedImage })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Image saved successfully!');
                            window.location.href = 'menu.php'; // Redirigir a menu.php
                        } else {
                            alert('Failed to save image.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
                } else {
                    alert('Please select an image first.');
                }
            });
        });
    </script>
</body>
</html>
