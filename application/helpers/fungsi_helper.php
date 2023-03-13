<?php 

function check_not_login()
{
    $ci =& get_instance();
    $user_session = $ci->session->userdata('id');
    if(!$user_session)
    {
        redirect('login');
    }
}

// function check_already_login()
// {
//     $ci =& get_instance();
//     $user_session = $ci->session->userdata('role');
//     var_dump($user_session);
//     if($user_session == '1') {
//         redirect('mahasiswa');
//     }
//     // if($user_session)
//     // {
//     //     if($user_session == 1)  {
//     //         redirect('mahasiswa');
//     //     } elseif ($user_session == 2) {
//     //         redirect('dosen');
//     //     } else {
//     //         redirect('admin');
//     //     }
//     // }
// }

// function check_mahasiswa()
// {
//     $ci =& get_instance();
//     $ci->load->library('fungsi');
//     $user_session = $ci->session->userdata('id');
//     // $role = $ci->session->userdata('role');
//     if($user_session)
//     {
//         if($ci->fungsi->user_login()->role != 2 || $ci->fungsi->user_login()->role == 3) {
//             redirect('mahasiswa');
//             // if($ci->fungsi->user_login()->role == 2) {
//             //     return redirect('dosen');
//             // } elseif ($ci->fungsi->user_login()->role == 3) {
//             //     return redirect('admin');
//             // }
//         }
//     }

// }