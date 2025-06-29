<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Quotes from CSV | QuoteShare</title>
    <link rel="stylesheet" href="./public/assets/reset.css">
    <link rel="stylesheet" href="./public/assets/styles.css">
    <link rel="stylesheet" href="./public/assets/nav.css">
    <link rel="stylesheet" href="./public/assets/import-csv.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="layout-container">
    <?php require_once './app/views/partials/nav.php'; ?>

    <main class="main-content">
        <div class="csv-import-container">
            <h1>Import Quotes from CSV</h1>
            <p>Upload a CSV file to add multiple quotes at once.</p>
            <form id="csv-import-form" class="csv-import-form" enctype="multipart/form-data">
                <input type="file" id="csv-file" name="csv_file" accept=".csv">
                <button type="submit" class="btn btn-primary">Upload CSV</button>
            </form>
            <div id="import-message" class="import-message" style="display: none;"></div>
        </div>
    </main>

    <?php require_once './app/views/partials/footer.php'; ?>
</div>

<script>
    document.getElementById('csv-import-form').addEventListener('submit', async function (e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(this);
        const messageDiv = document.getElementById('import-message');
        messageDiv.style.display = 'none';

        try {
            const response = await fetch('?path=/quotes/import-csv', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${response.ok && data?.success ? 'success' : 'error'}`;
            messageDiv.innerHTML = `
                    <span class="message-icon">${response.ok && data?.success ? '✓' : '⚠️'}</span>
                    ${data.message}
                `;

            form.insertAdjacentElement('beforebegin', messageDiv);

            if (data?.success) {
                form.reset();

                setTimeout(() => {
                    window.location.href = '?path=/';
                }, 2500);
            } else {
                alert(data.message); 
            }
        } catch (error) {
            alert('Error importing quotes from csv');
        }
    });
</script>
</body>
</html>
