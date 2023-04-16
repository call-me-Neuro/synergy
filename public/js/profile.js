let a = document.getElementsByClassName("my_anket").length
if (a > 4) {
    let size = (a - 4) * 30
    let block = document.getElementsByClassName("block_for_ankets")[0]
    console.log(size)
    block.style.height = (block.offsetHeight + size) + 'px'
}
