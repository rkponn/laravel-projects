import './bootstrap';
import Search from './live-search';

// only load if search
if (document.querySelector('.header-search-icon')) {
   new Search(); 
}