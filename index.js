 document.addEventListener('DOMContentLoaded', () => {
        const tableRows = document.querySelectorAll('tr');

        // Animasi efek 3D pada tabel
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', () => {
                row.style.transform = 'rotateY(15deg)';
                row.style.transition = 'transform 0.3s ease-in-out';
            });

            row.addEventListener('mouseleave', () => {
                row.style.transform = 'rotateY(0deg)';
                row.style.transition = 'transform 0.3s ease-in-out';
            });
        });

        // Hover effect pada judul (h1)
        const title = document.querySelector('h1');
        title.addEventListener('mouseover', () => {
            title.style.transform = 'scale(1.1)';
        });
        title.addEventListener('mouseout', () => {
            title.style.transform = 'scale(1)';
        });
    });