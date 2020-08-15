const truncate = {}

truncate.install = (Vue) => {
    Vue.prototype.$truncate = (text, number) => {
       if(text.length > 20) return text.trim().slice(0, number) + '...'
       else return text.trim()
    }
}

export default truncate