<!DOCTYPE html>
<html>

<head>
    <?php
    // Ganti URL Link Sesuai Project Yang Ada Di Firebase Realtime
    $databaseURL = "https://warung-pempek-default-rtdb.asia-southeast1.firebasedatabase.app/"; // Jangan Lupa Ganti Sesuai Link Project Yang Ada Di Firebase Realtime

    include("FirebaseConfig/firebaseRealtime.php");
    $db = new firebaseRealtime($databaseURL);

    $mode = isset($_GET['mode']) ? $_GET['mode'] : ""; // Meminta Mode Di URL
    $email = isset($_GET['email']) ? $_GET['email'] : ""; // Meminta Email/Username Di URL
    $password = isset($_GET['pw']) ? $_GET['pw'] : ""; // Meminta Password Di URL
    ?>

    <title>
        <?php
        $data = $db->retrieve("users", "user", "EQUAL", $email);
        $data = json_decode($data, 1);
        $user = "";
        $pw = "";

        if (is_array($data)) {
            foreach ($data as $users) {
                $user = $users['user'];
                $pw = $users['password'];
            }

            if (empty($mode)) {
                echo 'Mode Harus terisi!'; // Mode Harus Diisi Pada Url Link
            } else if ($mode != "daftar" && $mode != "login") {
                echo 'Mode Salah!'; // Jika Mode Tidak Sama Dengan "daftar" dan "login"
            } elseif (empty($email)) {
                echo 'Email harus terisi!'; // Email Harus Diisi Pada Url Link
            } elseif (empty($password)) {
                echo 'Password harus terisi!'; // Password Harus Diisi Pada Url Link
            } elseif ($mode == "login") {
                // ============================= Login Akun ============================== //
                if (empty($user)) {
                    echo 'Akun belum terdaftar!'; // Peringatan Jika User Belum Terdaftar
                } else if ($pw != $password) {
                    echo 'Password salah!'; // Peringatan Jika Password User Salah
                } else if ($user == $email && $pw == $password) {
                    echo 'Berhasil Login'; // Jika User dan Password Benar, Maka Berhasil Login
                }
                // ============================= Login Akun ============================== //
            } else if ($mode == "daftar") {
                // ============================= Daftar Akun ============================== //
                if (empty($user)) {
                    $insert = $db->insert("users", [
                        "user" => $email,
                        "password" => $password,
                    ]);
                    echo "User Berhasil Ditambahkan!"; // User Berhasil Ditambahkan
                } else if (!empty($user)) {
                    echo "User Telah Terdaftar!"; // Peringatab Jika User Sudah Didaftarkan
                }
                // ============================= Daftar Akun ============================== //
            }
        }
        ?>
    </title>
</head>

</html>