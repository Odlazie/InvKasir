<?php



if (!function_exists('rupiah')) {
    // format rupiah indonesia
    function rupiah($nominal)
    {
        return number_format($nominal, 0, ',', '.');
    }
}

function aduh($kolom = '')
{
    $model = model('App\Models\m_pengguna');
    $data = $model
        ->where('212412_id', session()->get('idweh'))
        ->get()
        ->getRow();

    // $data = $model->select('212412_id')->where('212412_id', session()->get('idweh'))->get()->getRow();
    if ($kolom == '') {
        return $data;
    } else {
        return $data->{$kolom};
    }
}
