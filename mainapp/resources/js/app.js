import './bootstrap';
import Search from './live-search';
import Chat from "./chat";

// only load if search icon
if (document.querySelector('.header-search-icon')) {
   new Search(); 
}

if (document.querySelector('.header-chat-icon')) {
   new Chat(); 
}