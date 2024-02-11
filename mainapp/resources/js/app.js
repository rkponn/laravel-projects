import './bootstrap';
import Search from './live-search';
import Chat from "./chat";
import Profile from "./profile";

function initializeComponent(selector, className) {
   const element = document.querySelector(selector);
   if (element) {
     new className();
   }
 }
 
 // Usage
initializeComponent('.header-search-icon', Search);
initializeComponent('.header-chat-icon', Chat);
initializeComponent('.profile-nav', Profile);