<!DOCTYPE html>
<html lang="en">
<head>          
            
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partner Preference</title>
   <link rel="stylesheet" href="../assets/css/partner_prefernce.css">         
</head>
<body>
<div class="preference-container">
    <h2>Partner Preference</h2>
    <p class="subtitle">Set your preferences to find better
         matches</p>

    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <div class="alert-success">Your partner preference has been saved successfully!</div>
    <?php endif; ?>     

    <form method="POST" action="partner_preferencesApi.php" class="pref-form">

        <div class="form-row">
            <div class="form-group">
                <label>Age Range</label>
                <div class="range-group">
                    <input type="number" name="min_age" placeholder="Min Age">
                    <input type="number" name="max_age" placeholder="Max Age">
                </div>
            </div>

            <div class="form-group">
                <label>Height Range (ft)</label>
                <div class="range-group">
                    <input type="number" step="0.01" name="min_height" placeholder="Min Height">
                    <input type="number" step="0.01" name="max_height" placeholder="Max Height">
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Religion</label>
                <select name="religion">
                    <option value="Hindu">Hindu</option>
                    <option value="Muslim">Muslim</option>
                    <option value="Christian">Christian</option>
                    <option value="Sikh">Sikh</option>
                </select>
            </div>

            <div class="form-group">
                <label>Caste</label>
                <input type="text" name="caste" placeholder="e.g. Brahmin">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Education</label>
                <input type="text" name="education" placeholder="e.g. B.Tech, MBBS">
            </div>

            <div class="form-group">
                <label>Minimum Income</label>
                <input type="text" name="min_income" placeholder="e.g. 2 Lakh per Annum">
            </div>
        </div>

        <div class="form-group">
            <label>Preferred Location</label>
            <input type="text" name="location" placeholder="e.g. Mumbai, Delhi">
        </div>

        <button type="submit" class="btn-save">Save Preference</button>
    </form>
</div>
</body> 
</html>