function get_date( str )
{
    return str.slice(8, 10) + "." + str.slice(5, 7) + "." + str.slice(0, 4);
}

function get_datetime( str )
{
    return get_date(str) + " в " + str.slice(11, 16);
}