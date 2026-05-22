function deleteAllFiles() {
    const fileCount = document.querySelector('.total-files-count')?.textContent || 0;
    
    if (fileCount === 0 || fileCount === '0') {
        alert('Tidak ada file untuk dihapus');
        return;
    }

    if (!confirm(`Yakin mau menghapus semua ${fileCount} file? Operasi ini tidak bisa dibatalkan!`)) {
        return;
    }

    fetch('/api/admin/files/delete-all', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('Error: ' + (data.error || 'Gagal menghapus file'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal menghapus file: ' + error.message);
    });
}
