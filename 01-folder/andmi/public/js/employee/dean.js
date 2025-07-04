$(document).ready(function() {
    function showToast(position, icon, toast_message) {
        Swal.fire({
            toast: true,
            position: position,
            icon: icon,
            title: toast_message,
            background: "#f5f6f7",
            timerProgressBar: true,
            showCloseButton: true,
            showConfirmButton: false,
            timer: 4000
        });
    }

    $('#professorTable').DataTable({
        paging: true,
        searching: true,
        responsive: true,
        language: {
            url: uzLocaleFile
        }
    });

    $('#studentTable').DataTable({
        paging: true,
        searching: true,
        responsive: true,
        language: {
            url: uzLocaleFile
        }
    });

    const assignedPairs = new Set();
    let selectedProfessor = null;

    $('#professorTable tbody').on('click', 'tr', function() {
        $('#professorTable').DataTable().$('tr.selected-row').removeClass('selected-row');
        $(this).addClass('selected-row');
        selectedProfessor = {
            id: $(this).data('id'),
            name: $(this).find('td').eq(1).text()
        };
    });

    $('#studentTable tbody').on('click', 'tr', function() {
        $('#studentTable').DataTable().$('tr.selected-row').removeClass('selected-row');
        $(this).addClass('selected-row');
        if (selectedProfessor) {
            const student = {
                id: $(this).data('id'),
                name: $(this).find('td').eq(1).text()
            };
            const pairKey = `${selectedProfessor.id}-${student.id}`;
            if (!assignedPairs.has(pairKey)) {
                $('#assignedTableBody').append(`
                    <tr class="fade-in">
                        <td data-id='${selectedProfessor.id}'>${selectedProfessor.name}</td>
                        <td data-id='${student.id}'>${student.name}</td>
                    </tr>
                `);
                assignedPairs.add(pairKey);
            } else {
                showToast('top-end', 'error', 'Bu talaba allaqachon biriktirilgan!');
            }
        } else {
            showToast('top-end', 'error', 'Iltimos, avval professorni tanlang!');
        }
    });

    $('#saveChanges').on('click', function () {
        const dataToSend = [];
        $('#assignedTableBody tr').each(function () {
            const professor = $(this).find('td').eq(0);
            const student = $(this).find('td').eq(1);
            dataToSend.push({
                employee_id: professor.data('id'),
                student_id: student.data('id'),
            });
        });
    
        $.ajax({
            url: '/employee/dean/attach-student',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                data: dataToSend,
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }),
            success: function () {
                showToast('top-end', 'success', 'O’zgarishlar muvaffaqiyatli saqlandi!');
                setTimeout(function () {
                    window.location.reload();
                }, 2500);
            },
            error: function () {
                showToast('top-end', 'error', 'O’zgarishlarni saqlashda xatolik yuz berdi.');
            }
        });
    });
});