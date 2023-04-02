function checkArrays(a, b){
    if (a.length != b.length) {
        console.error("vectors do not have the same size !");
    }
}

function values(a){
    return Object.values(a).filter((value) => {
        return typeof value == "number";
    });
}

function numberToArray(value, lengthOftheArray){
    if (typeof value === "number")
        return Array.from({length: lengthOftheArray}, () => value);
    else
        return values(value);
}

export let Vectors = {
    values: function(v){
        return values(v);
    },

    /** @type {(array, array, function) => Array} */
    vectorOperationTemplate: function(a_, b_, operation){
        let a = values(a_);
        let b = numberToArray(b_, a.length);
        checkArrays(a, b);

        let ret = [];
        for (let i = 0; i < a.length; i++) {
            ret[i] = operation(a[i], b[i]);
        }
        return ret;
    },

    /** @type {(a: Array, b: Array | number) => Array} */
    sustract: function(a, b){
        return this.vectorOperationTemplate(a, b, function(a, b){
            return a - b;
        })
    },

    /** @type {(a: Array, b: Array | number) => Array} */
    add: function(a, b){
        return this.vectorOperationTemplate(a, b, function(a, b){
            return a + b;
        })
    },

    /** @type {(a: Array, b: Array | number) => Array} */
    divide: function(a, b){
        return this.vectorOperationTemplate(a, b, function(a, b){
            return a / b;
        })
    },

    /** @type {(a: Array, b: Array | number) => Array} */
    multiply: function(a, b){
        return this.vectorOperationTemplate(a, b, function(a, b){
            return a * b;
        })
    },

    /**@type {(any, any) => number} */
    dot: function(a, b){
        const arA = values(a);
        const arB = values(b);
        checkArrays(arA, arB);

        let dot = 0;
        for (let i = 0; i < arA.length; i++) {
            dot += arA[i] * arB[i];
        }
        return dot;
    },
    /**@type {(any, any) => number} */
    cross: function(a_, b_){
        const a = values(a_);
        const b = values(b_);
        checkArrays(a, b);

        if (a.length < 3) console.error("can't do a cross product with less than a 3d vector");

        return [
            a[1] * b[2] - a[2] * b[1],
            a[2] * b[0] - a[0] * b[2],
            a[0] * b[1] - a[1] * b[0]
        ];
    },
    /**@type {(any) => number} */
    length: function(a){
        const arA = values(a);

        let n = 0;
        for (let i = 0; i < Math.max(arA.length, 3); i++) {
            n += arA[i] * arA[i];
        }
        
        return Math.sqrt(n);
    },

    /**@type {(any) => any} */
    normalize: function(a_){
        const a = values(a_);
        const l = this.length(a);
        
        return this.divide(a, l);
    }
};