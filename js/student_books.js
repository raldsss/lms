function showDetails(image, title, author, publisher, pubYear, copies, bookId, bookCategory) {
  document.getElementById('detailsImage').src = image;
  document.getElementById('detailsTitle').textContent = title;
  document.getElementById('detailsDescription').textContent = author;
  document.getElementById('detailsPublisher').textContent = publisher;
  document.getElementById('detailsPubYear').textContent = pubYear;
  document.getElementById('detailsCopies').textContent = copies;

  document.querySelector('#borrowForm input[name="book_id"]').value = bookId;
  document.querySelector('#borrowForm input[name="book_title"]').value = title;
  document.querySelector('#borrowForm input[name="book_category"]').value = bookCategory;

  const borrowQuantityInput = document.getElementById('exampleInputCopies');
  borrowQuantityInput.max = copies;
  borrowQuantityInput.placeholder = `${copies}`;

  document.getElementById('detailsPanel').style.display = 'block';
}

document.getElementById('borrowForm').addEventListener('submit', function (e) {
  const borrowQuantityInput = document.getElementById('exampleInputCopies');
  const borrowQuantity = parseInt(borrowQuantityInput.value, 10);
  const maxQuantity = parseInt(borrowQuantityInput.max, 10);

  if (borrowQuantity > maxQuantity) {
      e.preventDefault();
      alert(`You cannot borrow more than ${maxQuantity} copies.`);
  }
});

document.addEventListener('DOMContentLoaded', function () {
  const today = new Date().toISOString().split('T')[0];
  document.getElementById('exampleInputDate').value = today;
  document.getElementById('exampleInputReturn').value = today;
});
function closeDetails() {
  document.getElementById('detailsPanel').style.display = 'none';
}

document.getElementById('bookSearch').addEventListener('input', function () {
const searchValue = this.value.toLowerCase();
const books = document.querySelectorAll('.product-card');
let hasVisibleBooks = false;

books.forEach(book => {
  const title = book.querySelector('h3').textContent.toLowerCase();
  if (title.includes(searchValue)) {
    book.style.display = '';
    hasVisibleBooks = true;
  } else {
    book.style.display = 'none';
  }
});

const noBooksMessage = document.getElementById('noBooksMessage');
noBooksMessage.style.display = hasVisibleBooks ? 'none' : 'block';
});
