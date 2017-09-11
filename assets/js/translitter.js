
var ru2en = {
  ru_str : "\/\ їєіІЯЇЄАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюя\(\):;\"\'-+«»\,.&!?—%*№[]{}",

//  en_str : ['_','_','A','B','V','G','D','E','JO','ZH','Z','I','J','K','L','M','N','O','P','R','S','T',
//    'U','F','H','C','CH','SH','SHH',String.fromCharCode(35),'I',String.fromCharCode(39),'JE','JU',
//    'JA','a','b','v','g','d','e','jo','zh','z','i','j','k','l','m','n','o','p','r','s','t','u','f',
//    'h','c','ch','sh','shh',String.fromCharCode(35),'i',String.fromCharCode(39),'je','ju','ja'],

  en_str : ['_','_','i','e','i','i','ja','ii','e','a','b','v','g','d','e','jo','zh','z','i','j','k','l','m','n','o','p','r','s','t',
            'u','f','kh','c','ch','sh','shh','','y','','eh','ju','ja',
            'a','b','v','g','d','e','jo','zh','z','i','j','k','l','m','n','o','p','r','s','t','u','f',
            'kh','c','ch','sh','shh','','y','','eh','ju','ja','_','_','_','_','_','_','_','','','','','','and','','','','','','','','','',''],

  
  translit : function(org_str) {
    var tmp_str = "";
    for(var i = 0, l = org_str.length; i < l; i++) {
      var s = org_str.charAt(i), n = this.ru_str.indexOf(s);
      if(n >= 0) { tmp_str += this.en_str[n]; }
      else { tmp_str += s; }
    }
    return tmp_str;
  },
  tr : function(org_str) {
    var tmp_str = [];
    for(var i = 0, l = org_str.length; i < l; i++) {
      var s = org_str.charAt(i), n = this.ru_str.indexOf(s);
      if(n >= 0) { tmp_str[tmp_str.length] = this.en_str[n]; }
      else { tmp_str[tmp_str.length] = s; }
    }
    return tmp_str.join("");
  },
  t : function (inp){
    return inp.replace(/(.)/g,function(a) { return ru2en.ru2en[a] });
  },
  t1 : function (inp) {
    var a = inp.split("");
    for (var i=0,aL=a.length;i<aL;i++) {a[i] = ru2en.ru2en[a[i]]}
    return a.join("");
  },
  ttt : function (inp){
    var reg;
    for (var a in ru2en.ru2en) {
      reg = new RegExp(a, "g");
      inp = inp.replace(reg, ru2en.ru2en[a]);
    }
    return inp;
  }
}