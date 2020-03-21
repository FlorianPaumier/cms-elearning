<?php require(VIEW_PATH . "/partials/header.view.php");  ?>

    <h2>User List</h2>
    <table>
        <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Email</th>
            <th>Roles</th>
        </tr>
        </thead>
        <tbody>
        <?php
            foreach ($users as $user){
                echo "<tr>
            <td>".$user->getId()."</td>
            <td>".$user->getUsername()."</td>
            <td>".$user->getEmail()."</td>
            <td>".implode(", ",$user->getRoles())."</td>
            <td><button><a href='/user/".$user->getId()."'>Voir</a></button></td>
        </tr>";
            }

        ?>


        </tbody>
    </table>

<?php require(VIEW_PATH . "/partials/footer.view.php") ?>