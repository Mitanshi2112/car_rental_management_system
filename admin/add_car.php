<?php  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Car | Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="add_car.css">
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

  <div class="admin-wrapper">
    <header class="admin-header">
      <h1><i class="fa-solid fa-car-side"></i> Add New Car</h1>
      <a href="dashboard.php" class="btn btn-light">
        <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
      </a>
    </header>

    <form class="card form-grid" action="save_car.php" method="post" enctype="multipart/form-data">
      <div class="grid-2">
        <div class="form-group">
          <label for="car_name">Car Name *</label>
          <input type="text" id="car_name" name="car_name" placeholder="Honda City, Fortuner" required>
        </div>

        <div class="form-group">
          <label for="car_model">Model Year *</label>
          <input type="number" id="car_model" name="car_model" placeholder="2023" min="1980" max="2099" required>
        </div>
      </div>

      <div class="grid-3">
        <div class="form-group">
          <label for="car_type">Car Type *</label>
          <select id="car_type" name="car_type" required>
            <option value="">Select</option>
            <option>SUV</option>
            <option>MUV</option>
            <option>Sedan</option>
            <option>Hatchback</option>
            <option>Luxury</option>
            <option>Electric</option>
          </select>
        </div>

        <div class="form-group">
          <label for="fuel_type">Fuel Type *</label>
          <select id="fuel_type" name="fuel_type" required>
            <option value="">Select</option>
            <option>Petrol</option>
            <option>Diesel</option>
            <option>Electric</option>
            <option>Hybrid</option>
          </select>
        </div>

        <div class="form-group">
          <label for="transmission">Transmission *</label>
          <select id="transmission" name="transmission" required>
            <option value="">Select</option>
            <option>Manual</option>
            <option>Automatic</option>
          </select>
        </div>
      </div>

      <div class="grid-3">
        <div class="form-group">
          <label for="seats">Seating Capacity *</label>
          <input type="number" id="seats" name="seats" placeholder="5" min="2" max="12" required>
        </div>

        <div class="form-group">
          <label for="price_hour">Price / Hour (₹) *</label>
          <input type="number" id="price_hour" name="price_hour" placeholder="500" min="0" step="0.01" required>
        </div>

        <div class="form-group">
          <label for="price_day">Price / Day (₹) *</label>
          <input type="number" id="price_day" name="price_day" placeholder="3000" min="0" step="0.01" required>
        </div>
      </div>

      <!-- Availability -->
      <div class="grid-2">
        <div class="form-group">
          <label for="availability">Availability *</label>
          <select id="availability" name="availability" required>
            <option value="">Select</option>
            <option value="available">Available</option>
            <option value="not_available">Not Available</option>
          </select>
        </div>
        <div class="form-group">
          <label for="reg_no">Registration No. (optional)</label>
          <input type="text" id="reg_no" name="reg_no" placeholder="GJ01 AB 1234">
        </div>
      </div>

      <!-- Facilities -->
      <div class="form-group">
        <label>Facilities</label>
        <div class="checks">
          <label><input type="checkbox" name="facilities[]" value="AC"> AC</label>
          <label><input type="checkbox" name="facilities[]" value="GPS"> GPS</label>
          <label><input type="checkbox" name="facilities[]" value="Music System"> Music System</label>
          <label><input type="checkbox" name="facilities[]" value="Bluetooth"> Bluetooth</label>
          <label><input type="checkbox" name="facilities[]" value="Airbags"> Airbags</label>
          <label><input type="checkbox" name="facilities[]" value="ABS"> ABS</label>
          <label><input type="checkbox" name="facilities[]" value="Driver Available"> Driver Available</label>
          <label><input type="checkbox" name="facilities[]" value="Sunroof"> Sunroof</label>
        </div>
      </div>

      <!-- Image Upload -->
      <div class="grid-2">
        <div class="form-group">
          <label for="car_image">Upload Car Image *</label>
          <input type="file" id="car_image" name="car_image" accept="image/png, image/jpeg" required>
          <small>Allowed: JPG, PNG. Max 3 MB.</small>
        </div>

        <div class="form-group preview-group">
          <label>Preview</label>
          <img id="preview" src="" alt="Preview will appear here">
        </div>
      </div>

      <!-- Description -->
      <div class="form-group">
        <label for="description">Description (optional)</label>
        <textarea id="description" name="description" rows="4" placeholder="Short details about the car..."></textarea>
      </div>

      <!-- Actions -->
      <div class="actions">
        <button type="submit" class="btn btn-primary">
          <i class="fa-solid fa-floppy-disk"></i> Save Car
        </button>
        <button type="reset" class="btn">
          <i class="fa-solid fa-rotate-left"></i> Reset
        </button>
      </div>
    </form>
  </div>

  <script>
    // Image preview
    const fileInput = document.getElementById('car_image');
    const preview   = document.getElementById('preview');
    fileInput.addEventListener('change', function () {
      const file = this.files[0];
      if (!file) { preview.src=''; preview.style.display='none'; return; }
      if (!file.type.match(/image.*/)) { alert('Please choose an image file'); this.value=''; return; }
      if (file.size > 3 * 1024 * 1024) { alert('Max 3 MB allowed'); this.value=''; return; }
      const url = URL.createObjectURL(file);
      preview.src = url;
      preview.style.display = 'block';
    });
  </script>
</body>
</html>
