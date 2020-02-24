<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Description">
    <title>Admin Component</title>
    <link rel="stylesheet" href="../../assets/styles/form.css">
</head>
<body>
<section>
    <h1>Formulaire</h1>
    <div class="form">
        <form action="#">
            <input type="file" class="btn" accept="image/*"><br>

            <label for="input_text">
                <input type="text" name="input_text" placeholder="Title...">
            </label><br>
            <label for="input_date">
                <input type="date" name="input_date">
            </label><br>

            <label for="input_textarea">
                <select>
                    <option class="default">Catégorie...</option>
                    <option>1</option>
                    <option>2</option>
                </select>
            </label><br>
            <label for="input_radio">
                <input type="radio" name="input_radio">
                <input type="radio" name="input_radio">
            </label><br>
            <label for="input_checkbox">
                <input type="checkbox" name="input_checkbox"><br>
            </label><br>
            <input type="file" class="btn" accept="video/*">
            <input class="btn" type="submit">
        </form>
    </div>

</section>
<section class="button">

</section>
<section class="calendar">

</section>
<section class="sidebar">

</section>
</body>
</html>