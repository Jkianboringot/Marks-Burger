@props(['productName','quantity','total'])
<div class="card selection-box">

      <div class="inner-selection">
          <img src="admin-lte\assets\img\ego-profile.jpg" alt="No Image">

      </div>
      <div class="selection-description">
          <h2 class="text-title">Name:<span class="text-variable">89
                  <!-- product_name
                     really need this shit to be eager loaded and hydrated what ever that means -->
              </span></h2>
          <!-- <h2 class="text-title">Product Name<span class="text-variable">89</span></h2> -->
          <h2 class="text-title">Quantity:<span class="text-variable">89
                  <!-- total_quantity_variable -->
              </span></h2>
          <h2 class="text-title">total:<span class="text-variable">89
                  <!-- total_per_product  _variable -->
              </span></h2>
      </div>
  </div>