import Fonts from './settings/fonts.js';
import Maps from './settings/maps.js';
import Packages from './settings/packages.js';

class Settings 
{

  init()
  {
    this.fonts = new Fonts();
    this.maps  = new Maps();
    this.packages = new Packages();
  }


}


export default Settings;