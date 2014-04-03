    /**
    reference: https://stackoverflow.com/questions/11246758/how-to-get-unique-values-in-a-array
    */
    Array.prototype.contains = function(v) {
        for(var i = 0; i < this.length; i++) {
            if(this[i] === v) return true;
        }
        return false;
    };
    /**
    reference: https://stackoverflow.com/questions/11246758/how-to-get-unique-values-in-a-array
    */
    Array.prototype.unique = function() {
        var arr = [];
        for(var i = 0; i < this.length; i++) {
            if(!arr.contains(this[i])) {
                arr.push(this[i]);
            }
        }
        return arr; 
    }