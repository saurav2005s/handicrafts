<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Handicraft Product Review</title>

  <style>
    body {
  font-family: 'Segoe UI', sans-serif;
  background: #f3f3f3;
  margin: 0;
  padding: 0;
}

.container {
  max-width: 600px;
  margin: 40px auto;
  background: white;
  padding: 25px;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

h1, h2 {
  text-align: center;
  color: #4a2d16;
}

form {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

input, select, textarea, button {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 16px;
}

button {
  background-color: #8b5e3c;
  color: white;
  border: none;
  cursor: pointer;
}

button:hover {
  background-color: #6f4629;
}

.review {
  background-color: #f9f9f9;
  border-left: 5px solid #8b5e3c;
  padding: 15px;
  margin: 15px 0;
  border-radius: 6px;
}

.review strong {
  color: #4a2d16;
}

.rating {
  color: #ffb703;
}
/* block */

.testimonial-box {
    margin-top: 10%;
    margin-left: 17%;
  background-color: #b06969;
  padding: 50px;
  border-radius: 10px;
  text-align: center;
  width: 60%;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.heading {
  font-size: 50px;
  font-weight: bold;
  color: black;
  text-shadow: 2px 2px 5px rgba(0,0,0,0.5);
  margin-bottom: 20px;
}

.subheading {
  font-size: 20px;
  color: black;
  text-shadow: 1px 1px 3px rgba(0,0,0,0.4);
}

  </style>
</head>
<body>
     <div class="testimonial-box">
    <h1 class="heading">What Our Customers Say</h1>
    <p class="subheading">Hear from our wonderful guests and see our ratings from across the web!</p>
  </div>
  
  <div class="container">
    <h1>Product Review</h1>
    
    <form id="reviewForm">
      <input type="text" id="name" placeholder="Your Name" required />
      <input type="email" id="email" placeholder="Your Email" required />
      
      <label for="rating">Rating:</label>
      <select id="rating" required>
        <option value="">Select</option>
        <option value="5">★★★★★</option>
        <option value="4">★★★★☆</option>
        <option value="3">★★★☆☆</option>
        <option value="2">★★☆☆☆</option>
        <option value="1">★☆☆☆☆</option>
      </select>
      
      <textarea id="message" placeholder="Write your review..." required></textarea>
      <button type="submit">Submit Review</button>
    </form>

    <h2>Customer Reviews</h2>
    <div id="reviewsContainer"></div>
    
  </div>

  <script>
  const productId = "product123";

// Load existing reviews from PHP
function loadReviews() {
  fetch(`fetch_reviews.php?product_id=${productId}`)
    .then(res => res.json())
    .then(reviews => {
      const container = document.getElementById("reviewsContainer");
      container.innerHTML = "";

      reviews.forEach(({ name, rating, message }) => {
        const reviewHTML = `
          <div class="review">
            <p><strong>${name}</strong> - <span class="rating">${"★".repeat(rating)}${"☆".repeat(5 - rating)}</span></p>
            <p>${message}</p>
          </div>
        `;
        container.innerHTML += reviewHTML;
      });
    });
}

// Handle form submission with fetch()
document.getElementById("reviewForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const formData = new FormData();
  formData.append("product_id", productId);
  formData.append("name", document.getElementById("name").value);
  formData.append("email", document.getElementById("email").value);
  formData.append("rating", document.getElementById("rating").value);
  formData.append("message", document.getElementById("message").value);

  fetch("submit_review.php", {
    method: "POST",
    body: formData
  })
    .then(res => res.text())
    .then(response => {
      if (response === "success") {
        document.getElementById("reviewForm").reset();
        loadReviews();
      } else {
        alert("Error submitting review.");
      }
    });
});

// Initial load
loadReviews();

</script>
  
</body>
</html>
