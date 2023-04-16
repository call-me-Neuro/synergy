function create_input() {
    i++
    form.style.height = form.offsetHeight + 60 + 'px'
    reg.style.height = reg.offsetHeight + 60 + 'px'
    let my_input = document.createElement('input')
    let div = document.createElement('div')
    div.className = 'just_input'
    my_input.className = 'my_input'
    my_input.type = 'text'
    my_input.name = 'field'+i
    if (language == 'RU') {
        my_input.placeholder = 'Вопрос'
    }
    else {
        my_input.placeholder = 'Question'
    }
    hid.value = i
    div.append(my_input)
    buttons.insertAdjacentElement('beforebegin', div)
}
let language = document.getElementsByClassName('lang-btn')[0].text
let hid = document.getElementById('counter')
let i = hid.value
let buttons = document.getElementById('down_field')
let button = document.getElementById('my_button')
button.onclick = create_input

let form = document.getElementsByClassName('my_form')[0]
let reg = document.getElementsByClassName('registration_form')[0]

