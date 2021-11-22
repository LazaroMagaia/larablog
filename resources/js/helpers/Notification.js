class Notification
{
    success()
    {
        new Noty({
            type:'success',
            layout:'topRight',
            text:"Successfully done",
            timeout:1000,
        }).show();
    }
    alert()
    {
        new Noty({
            type:'alert',
            layout:'topRight',
            text:"Are You Sure ?",
            timeout:1000,
        }).show();
    }
    error()
    {
        new Noty({
            type:'alert',
            layout:'topRight',
            text:"Something went wrong !",
            timeout:1000,
        }).show();
    }
    warnig()
    {
        new Noty({
            type:'warnig',
            layout:'topRight',
            text:"Ops wrong!",
            timeout:1000,
        }).show();
    }
    image_Validation()
    {
        new Noty({
            type:'error',
            layout:'topRight',
            text:"Upload image less then 1Mb",
            timeout:1000,
        }).show();
    }
}

export default Notification = new Notification();
