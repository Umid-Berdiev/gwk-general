/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

// window.Vue = require("vue").default;

import Vue from "vue/dist/vue.js";

// Import Bootstrap
import "bootstrap/dist/css/bootstrap.css";
import "leaflet/dist/leaflet.js";

const header = new Vue({
  el: "#header",
  methods: {
    toggleSidebar() {
      toggleSidebar();
    }
  }
});

const sidebarMenu = new Vue({
  el: "#sidebar-menu",

  data() {
    return {
      isShown1: false,
      isShown2: false,
      isShown3: false,
      isShown4: false,
      isShown5: false,
      langs: false
    };
  },

  mounted() {
    toggleSidebar();
    responseLayout();
    if (sessionStorage.getItem("isShown1")) {
      this.isShown1 = JSON.parse(sessionStorage.getItem("isShown1"));
    }
    if (sessionStorage.getItem("isShown2")) {
      this.isShown2 = JSON.parse(sessionStorage.getItem("isShown2"));
    }
    if (sessionStorage.getItem("isShown3")) {
      this.isShown3 = JSON.parse(sessionStorage.getItem("isShown3"));
    }
    if (sessionStorage.getItem("isShown4")) {
      this.isShown4 = JSON.parse(sessionStorage.getItem("isShown4"));
    }
    if (sessionStorage.getItem("isShown5")) {
      this.isShown5 = JSON.parse(sessionStorage.getItem("isShown5"));
    }
    if (sessionStorage.getItem("langs")) {
      this.langs = JSON.parse(sessionStorage.getItem("langs"));
    }
  },

  methods: {
    persist(key) {
      if (key == "isShown1") {
        this.isShown1 = !this.isShown1;
        sessionStorage.setItem(key, this.isShown1);
        sessionStorage.setItem("isShown2", false);
        sessionStorage.setItem("isShown3", false);
        sessionStorage.setItem("isShown4", false);
        sessionStorage.setItem("isShown5", false);
      } else if (key == "isShown2") {
        this.isShown2 = !this.isShown2;
        sessionStorage.setItem("isShown1", false);
        sessionStorage.setItem(key, this.isShown2);
        sessionStorage.setItem("isShown3", false);
        sessionStorage.setItem("isShown4", false);
        sessionStorage.setItem("isShown5", false);
      } else if (key == "isShown3") {
        this.isShown3 = !this.isShown3;
        sessionStorage.setItem("isShown1", false);
        sessionStorage.setItem("isShown2", false);
        sessionStorage.setItem(key, this.isShown3);
        sessionStorage.setItem("isShown4", false);
        sessionStorage.setItem("isShown5", false);
      } else if (key == "isShown4") {
        this.isShown4 = !this.isShown4;
        sessionStorage.setItem("isShown1", false);
        sessionStorage.setItem("isShown2", false);
        sessionStorage.setItem("isShown3", false);
        sessionStorage.setItem(key, this.isShown4);
        sessionStorage.setItem("isShown5", false);
      } else if (key == "isShown5") {
        this.isShown5 = !this.isShown5;
        sessionStorage.setItem("isShown1", false);
        sessionStorage.setItem("isShown2", false);
        sessionStorage.setItem("isShown3", false);
        sessionStorage.setItem("isShown4", false);
        sessionStorage.setItem(key, this.isShown5);
      }
      else if (key == "langs") {
        this.langs = !this.langs;
        sessionStorage.setItem("isShown1", false);
        sessionStorage.setItem("isShown2", false);
        sessionStorage.setItem("isShown3", false);
        sessionStorage.setItem("isShown4", false);
        sessionStorage.setItem("isShown5", false);
        sessionStorage.setItem(key, this.langs);
      } else {
        sessionStorage.setItem("isShown1", false);
        sessionStorage.setItem("isShown2", false);
        sessionStorage.setItem("isShown3", false);
        sessionStorage.setItem("isShown4", false);
        sessionStorage.setItem("isShown5", false);
        sessionStorage.setItem("langs", false);
      }
    }
  }
});

function toggleSidebar() {
  let sidebar = document.getElementById("sidebar-menu");
  let content = document.getElementById("main-content");

  if (sidebar && content) {
    sidebar.classList.toggle("d-none");
    content.classList.toggle("col-md-9");
    content.classList.toggle("col-lg-10");
  }
}

function responseLayout() {
  let header = document.getElementById("header");
  let sidebarSticky = document.querySelector(".sidebar-sticky");
  let sidebar = document.getElementById("sidebar-menu");

  if (header && sidebarSticky && sidebar) {
    sidebar.style.top = header.offsetHeight + "px";
    sidebarSticky.style.height = `calc(100vh - ${header.offsetHeight}px)`;
  }
}
