function _clicked(elem, type = null, clss = null)
{
    if(type == 'radio'){
        const divs = document.querySelectorAll('.'+clss);
        divs.forEach( (item) => {
            item.nextElementSibling.classList.remove('active');
        });
    }
    elem.nextElementSibling.classList.toggle('active')
}

const QtyInput = (() => {
	const $qtyInputs = $(".qty-input");

	if (!$qtyInputs.length) return;

	const $inputs = $qtyInputs.find(".product-qty");
	const $countBtn = $qtyInputs.find(".qty-count");
	const qtyMin = parseInt($inputs.attr("min"));
	const qtyMax = parseInt($inputs.attr("max"));

	$inputs.on("change", function () {
		const $this = $(this);
		const $minusBtn = $this.siblings(".qty-count--minus");
		const $addBtn = $this.siblings(".qty-count--add");
		let qty = parseInt($this.val());

		if (isNaN(qty) || qty <= qtyMin) {
			$this.val(qtyMin);
			$minusBtn.attr("disabled", true);
		} else {
			$minusBtn.attr("disabled", false);

			if (qty >= qtyMax) {
				$this.val(qtyMax);
				$addBtn.attr("disabled", true);
			} else {
				$this.val(qty);
				$addBtn.attr("disabled", false);
			}
		}
        
	});

    $inputs.on("keyup", function () {
        changePrice(this.value)
    })

	$countBtn.on("click", function () {
		const operator = this.dataset.action;
		const $this = $(this);
		const $input = $this.siblings(".product-qty");
		let qty = parseInt($input.val());
        

		if (operator === "add") {
			qty += 1;

			if (qty >= qtyMin + 1) {
				$this.siblings(".qty-count--minus").attr("disabled", false);
			}

			if (qty >= qtyMax) {
				$this.attr("disabled", true);
			}
		} else {
			qty = qty <= qtyMin ? qtyMin : qty - 1;

			if (qty === qtyMin) {
				$this.attr("disabled", true);
			}

			if (qty < qtyMax) {
				$this.siblings(".qty-count--add").attr("disabled", false);
			}
		}
        _getPrice(this, PRODUCTID, qty)

        // changePrice(qty)
		$input.val(qty);
	});
})();

// const changePrice = (quantity) => {
//     const price = Number($price.getAttribute('price')) * quantity
//     $price.innerText = price.toLocaleString("en-US")
// }


document.querySelectorAll('.product-qty').forEach(input => {
    const min = parseInt(input.min);
    const max = parseInt(input.max);
  
    input.addEventListener('input', () => {
      let value = parseInt(input.value);
  
      if (isNaN(value)) {
        input.value = min;
      } else if (value > max) {
        input.value = max;
      } else if (value < min) {
        input.value = min;
      }
    });
});

const _getPrice = (button, productID, quantity) => {
    const parent        = button.parentElement.parentElement.parentElement
    const priceWindow   = parent.querySelector('.price')
    const spinner       = parent.querySelector('.fa-spinner')
    // const priceWindow = button.parentElement.parentElement.parentElement.querySelector('.price span')
    console.log(priceWindow)

    priceWindow.classList.remove('active')
    spinner.classList.add('active')

    setTimeout( async () => {
        const price = await _fetchPrice()
    }, 1000)
    // const price = Number(priceWindow.getAttribute('price')) * quantity
    // priceWindow.innerText = price.toLocaleString("en-US")
}
  

const _fetchPrice = async () => {
    try {
      const res = await fetch('https://api.example.com/data');
      if (!res.ok) throw new Error(`HTTP error! Status: ${res.status}`);
      
      const data = await res.json();
      console.log(data);
    } catch (err) {
      console.error('Fetch failed:', err);
    }
};
  
  
// Input design

document.querySelectorAll(".input-wrapper .form-control").forEach((input) => {
    const wrapper = input.closest(".input-wrapper");
    const check = () => {
      wrapper.classList.toggle("filled", input.value.trim() !== "");
    };
    input.addEventListener("focus", () => wrapper.classList.add("focused"));
    input.addEventListener("blur", () => wrapper.classList.remove("focused"));
    input.addEventListener("input", check);
    input.addEventListener("change", check);
    check(); 
});

document.querySelectorAll(".input-wrapper input").forEach((input) => {
    input.addEventListener('keyup', () => {
        if (!input.hasAttribute('required')) return;
        const val = input.value.trim();
        const check = (status) => {
            if (status === true) return input.classList.remove('error')
            return input.classList.add('error')
        }
        
        if (val == '') return check(false)
        check(true)
    })
});
  