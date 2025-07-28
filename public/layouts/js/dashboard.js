let slim = null;
function _confirm(event, message)
{
    const popup = confirm(message);
    if(!popup){
        event.preventDefault();
    }
    return false;
}
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

function _add_other_inputs()
{
    const addNewInput       = document.getElementById('addNewInput');
    let _newCol             = document.createElement('div');
    _newCol1.innerHTML      = 
    `
        <input type="text" name="sizes[]" class="form-control mt-3 rounded-4 bg-ddd" placeholder="المقاس - size">
    `;
    addNewInput.appendChild(_newCol);
}

const fetchSizes = (val) => {
    fetch(SIZES_URL + val)
    .then((response) => {
        if (!response.ok) throw new Error('Error in url');
        return response.json();
    }).then((data) => {
        const input = document.getElementById('sizes');
        input.innerHTML = '';
        if (data.length == 0) return alert('لا يوجد مقاسات مضافة لهذا النوع بعد');
        data.forEach( item => {
            input.innerHTML += `<option value="${item.id}">${item.name}</option>`;
        })
        if (slim) slim.destroy();
        slimSelector();
    }).catch((err) => {
        console.log(err);
    });
}

window.onload = () => {
    slimSelector();
}
const slimSelector = () => {
    slim = new SlimSelect({
        select: '#sizes',
        allowDeselect: true,
        allowDeselectOption: true,
        closeOnSelect: false,
        selectAll: true,
        deselectLabel: '<span class="removeItemFromSelect me-2">✖</span>',
        searchPlaceholder: 'ابحث عن مقاس',
    });
}