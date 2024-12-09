function approveBook(borrowId) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to approve this request?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            updateStatus(borrowId, 'Borrowed');
        } else {
            console.error(`Error: ${xhr.status} - ${xhr.responseText}`);
            Swal.fire('Error', 'Failed to update status. Please try again.', 'error');
        }
    });
}

function cancelBook(borrowId) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to cancel this request?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            updateStatus(borrowId, 'Cancelled');
        } else {
            console.error(`Error: ${xhr.status} - ${xhr.responseText}`);
            Swal.fire('Error', 'Failed to update status. Please try again.', 'error');
        }
    });
}

function updateStatus(borrowId, status) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_status.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                const response = xhr.responseText.trim();
                if (response === "Status updated successfully.") {
                    Swal.fire('Updated', `Status updated to ${status}`, 'success').then(() => {
                        window.location.href = 'borrow_notification.php';
                    });
                } else {
                    Swal.fire('Error', response, 'error');
                }
            } else {
                Swal.fire('Error', 'Failed to update status. Please try again.', 'error');
            }
        }
    };
    xhr.send('borrow_id=' + borrowId + '&status=' + status);
}


function myFunction() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }       
    }
}