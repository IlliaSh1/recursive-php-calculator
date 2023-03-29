const calcBtns = document.querySelectorAll('.calc__btn');
const calcInp = document.querySelector('.calc__res');
if(calcBtns.length > 0) {
    for(let i=0;i< calcBtns.length;i++) {
        const el =calcBtns[i];
        el.addEventListener('click', (e) => {
            console.log("123");
            let val = el.getAttribute("value");
            
            let calcInpVal=calcInp.value;
            if(val=="AC") 
            calcInp.setAttribute('value', "");
            else    
            calcInp.setAttribute('value', calcInpVal+val);
            e.preventDefault;
        })
    }
}

