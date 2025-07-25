function _toggle_customer_sidebar()
{
    const customer_sidebar  = document.getElementById('customer-sidebar');
    const body              = document.getElementsByTagName('body')[0];
    const overlay           = document.getElementById('overlay');
    customer_sidebar.classList.toggle('customer_sidebar_toggled');
    overlay.classList.toggle('overlay-toggled');
    body.classList.toggle('overflow-hidden');
}

function _upload_files(elem, recipter, types_allowd, _label, _check_count = null)
{
    if(_check_count != null){
        if(elem.files.length > _check_count){
            alert(`برجاء رفع ${_check_count} كحد أقصى`);
            return false;
        }
    }
    if(elem.files && elem.files[0]){
        let file_type = elem.files[0].name.split(".").pop().toLowerCase();
        if(types_allowd.includes(file_type)){
            document.querySelector(_label).classList.add('label-success');
            if(recipter == false) return false;
            const block = document.querySelector(recipter);
            const reader = new FileReader();
            reader.readAsDataURL(elem.files[0]);
            reader.onload = () => {
                block.src = reader.result;
            };
        }else{
            alert("برجاء رفع ملف مسموح به");
            return false;
        }
    }
}