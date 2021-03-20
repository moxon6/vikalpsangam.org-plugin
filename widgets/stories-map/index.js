import Vue from 'vue';
import App from './App.vue';

window.renderMap = (el, props = {}) => {
  new Vue({
    render: (createElement) => createElement(App, {
      props,
    }),
  }).$mount(el);
};
