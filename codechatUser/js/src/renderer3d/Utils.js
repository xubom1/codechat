
export const Utils = {
    /** @type { (filepath: string) => string} */
    readFile: async function(filepath){
        return await (await fetch(filepath)).text();
    },

     /** @type { (array, keyword) => array} */
    parseObjSearchKeywordInLine: function (lines, keyword){
        return lines.map(function(line){
            if (line.split(' ')[0] === keyword){
                return line;
            }
        }).filter(v => Boolean(v));
    },

    parseObjParseLinesOfloats: function(lines, outBuffer){
        for (const line of lines) {
            const element = [];
            line.split(' ').forEach(function(value, index){
                const parsedValue = parseFloat(value);
                if (!isNaN(parsedValue)) element.push(parsedValue);
            })
            outBuffer.push(element);
        }
    }
}