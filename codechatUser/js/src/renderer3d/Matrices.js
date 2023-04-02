import { Vectors } from "./Vectors";

export let Mat4 = {
    /**@type {(n:number) => Array} */
    identity: function(n = 1){
        return [
				n,  0,  0,  0,
				0,  n,  0,  0,
				0,  0,  n,  0,
				0,  0,  0,  1,
         ];
    },
    
    /** @type { (array, array) => array} */
    multiply: function(a, b) {
		const a00 = a[0 * 4 + 0];
		const a01 = a[0 * 4 + 1];
		const a02 = a[0 * 4 + 2];
		const a03 = a[0 * 4 + 3];
		const a10 = a[1 * 4 + 0];
		const a11 = a[1 * 4 + 1];
		const a12 = a[1 * 4 + 2];
		const a13 = a[1 * 4 + 3];
		const a20 = a[2 * 4 + 0];
		const a21 = a[2 * 4 + 1];
		const a22 = a[2 * 4 + 2];
		const a23 = a[2 * 4 + 3];
		const a30 = a[3 * 4 + 0];
		const a31 = a[3 * 4 + 1];
		const a32 = a[3 * 4 + 2];
		const a33 = a[3 * 4 + 3];
		const b00 = b[0 * 4 + 0];
		const b01 = b[0 * 4 + 1];
		const b02 = b[0 * 4 + 2];
		const b03 = b[0 * 4 + 3];
		const b10 = b[1 * 4 + 0];
		const b11 = b[1 * 4 + 1];
		const b12 = b[1 * 4 + 2];
		const b13 = b[1 * 4 + 3];
		const b20 = b[2 * 4 + 0];
		const b21 = b[2 * 4 + 1];
		const b22 = b[2 * 4 + 2];
		const b23 = b[2 * 4 + 3];
		const b30 = b[3 * 4 + 0];
		const b31 = b[3 * 4 + 1];
		const b32 = b[3 * 4 + 2];
		const b33 = b[3 * 4 + 3];
		return [
				b00 * a00 + b01 * a10 + b02 * a20 + b03 * a30,
				b00 * a01 + b01 * a11 + b02 * a21 + b03 * a31,
				b00 * a02 + b01 * a12 + b02 * a22 + b03 * a32,
				b00 * a03 + b01 * a13 + b02 * a23 + b03 * a33,
				b10 * a00 + b11 * a10 + b12 * a20 + b13 * a30,
				b10 * a01 + b11 * a11 + b12 * a21 + b13 * a31,
				b10 * a02 + b11 * a12 + b12 * a22 + b13 * a32,
				b10 * a03 + b11 * a13 + b12 * a23 + b13 * a33,
				b20 * a00 + b21 * a10 + b22 * a20 + b23 * a30,
				b20 * a01 + b21 * a11 + b22 * a21 + b23 * a31,
				b20 * a02 + b21 * a12 + b22 * a22 + b23 * a32,
				b20 * a03 + b21 * a13 + b22 * a23 + b23 * a33,
				b30 * a00 + b31 * a10 + b32 * a20 + b33 * a30,
				b30 * a01 + b31 * a11 + b32 * a21 + b33 * a31,
				b30 * a02 + b31 * a12 + b32 * a22 + b33 * a32,
				b30 * a03 + b31 * a13 + b32 * a23 + b33 * a33,
		];
    },

  	/**@type {(x:number, y:number, z:number) => Array} */
    translate: function(x, y, z) {
		return [
				1,  0,  0,  0,
				0,  1,  0,  0,
				0,  0,  1,  0,
				x,  y,  z,  1,
		];
    },
	
	/**@type {(x:number, y:number, z:number) => Array} */
    scale: function(x, y, z) {
		return [
			x,  0,  0,  0,
			0,  y,  0,  0,
			0,  0,  z,  0,
			0,  0,  0,  1,
		];
    },

	/** @type {(aspect: number, fov: number, zNear: number, zFar: number) => Array} */
	projection: function(aspect, fov, zNear, zFar) {
		const tanDemiFov = Math.tan(fov * .5);
		const zPortee = zNear - zFar;

		return [
				1 / (aspect * tanDemiFov), 0, 0, 0,
				0, 1 / tanDemiFov, 0, 0,
				0, 0, -(-zNear - zFar) / zPortee, -1,
				0, 0, 2 * zFar * zNear / zPortee, 0
		];
	},

	view: function(eyePos, lookAt, up) {
		let ret = this.identity(1);
	
		const f = Vectors.normalize(Vectors.add(lookAt, Vectors.multiply(eyePos, -1)));
		const s = Vectors.normalize(Vectors.cross(f, up));
		const u = Vectors.cross(s, f);
	
		ret[0] = s[0];
		ret[4] = s[1];
		ret[8] = s[2];
		ret[1] = u[0];
		ret[5] = u[1];
		ret[9] = u[2];
		ret[2] = -f[0];
		ret[6] = -f[1];
		ret[10] = -f[2];
		ret[12] = -Vectors.dot(s, eyePos);
		ret[13] = -Vectors.dot(u, eyePos);
		ret[14] = Vectors.dot(f, eyePos);
	
		return ret;
	},
	
	rotate: function(axis, a){

		// si l'angle de rotation est nulle
		if (a === 0) return this.identity();

		//u prends une norme égale a 1
		let u = Vectors.normalize(Vectors.values(axis));
	
		//ameliore la complexité temporelle
		const cosA = Math.cos(a);
		const sinA = Math.sin(a);
		const IcosA = 1 - cosA;
	
		//composer la matrice
		return [
			cosA + Math.pow(u[0], 2) * IcosA , u[1] * u[0] * IcosA + u[2] * sinA  , u[2] * u[0] * IcosA - u[1] * sinA  , 0,
			u[0] * u[1] * IcosA - u[2] * sinA  , cosA + Math.pow(u[1], 2) * IcosA , u[2] * u[1] * IcosA - u[0] * sinA  , 0,
			u[0] * u[2] * IcosA - u[1] * sinA  , u[1] * u[2] * IcosA - u[0] * sinA  , cosA + Math.pow(u[2], 2) * IcosA , 0,
										0  ,                              0  ,                                0, 1
    ];
	},

	/**@type {(array) => void} */
	log: function(m){
			let ret= "";
			for (let i = 0; i < 16; i++) {
				ret += Math.round(m[i] * 1000)/1000 + ",\t";
				if ((i + 1) % 4 === 0) ret += "\n";
			}
			console.log(ret);
	}
};