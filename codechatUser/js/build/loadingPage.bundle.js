(()=>{"use strict";function t(t,e){t.length!=e.length&&console.error("vectors do not have the same size !")}function e(t){return Object.values(t).filter((t=>"number"==typeof t))}let i={values:function(t){return e(t)},vectorOperationTemplate:function(i,r,n){let s=e(i),o=(a=r,h=s.length,"number"==typeof a?Array.from({length:h},(()=>a)):e(a));var a,h;t(s,o);let l=[];for(let t=0;t<s.length;t++)l[t]=n(s[t],o[t]);return l},sustract:function(t,e){return this.vectorOperationTemplate(t,e,(function(t,e){return t-e}))},add:function(t,e){return this.vectorOperationTemplate(t,e,(function(t,e){return t+e}))},divide:function(t,e){return this.vectorOperationTemplate(t,e,(function(t,e){return t/e}))},multiply:function(t,e){return this.vectorOperationTemplate(t,e,(function(t,e){return t*e}))},dot:function(i,r){const n=e(i),s=e(r);t(n,s);let o=0;for(let t=0;t<n.length;t++)o+=n[t]*s[t];return o},cross:function(i,r){const n=e(i),s=e(r);return t(n,s),n.length<3&&console.error("can't do a cross product with less than a 3d vector"),[n[1]*s[2]-n[2]*s[1],n[2]*s[0]-n[0]*s[2],n[0]*s[1]-n[1]*s[0]]},length:function(t){const i=e(t);let r=0;for(let t=0;t<Math.max(i.length,3);t++)r+=i[t]*i[t];return Math.sqrt(r)},normalize:function(t){const i=e(t),r=this.length(i);return this.divide(i,r)}},r={identity:function(t=1){return[t,0,0,0,0,t,0,0,0,0,t,0,0,0,0,1]},multiply:function(t,e){const i=t[0],r=t[1],n=t[2],s=t[3],o=t[4],a=t[5],h=t[6],l=t[7],c=t[8],u=t[9],d=t[10],g=t[11],f=t[12],p=t[13],m=t[14],E=t[15],T=e[0],A=e[1],w=e[2],R=e[3],b=e[4],v=e[5],y=e[6],_=e[7],S=e[8],x=e[9],L=e[10],M=e[11],B=e[12],F=e[13],I=e[14],U=e[15];return[T*i+A*o+w*c+R*f,T*r+A*a+w*u+R*p,T*n+A*h+w*d+R*m,T*s+A*l+w*g+R*E,b*i+v*o+y*c+_*f,b*r+v*a+y*u+_*p,b*n+v*h+y*d+_*m,b*s+v*l+y*g+_*E,S*i+x*o+L*c+M*f,S*r+x*a+L*u+M*p,S*n+x*h+L*d+M*m,S*s+x*l+L*g+M*E,B*i+F*o+I*c+U*f,B*r+F*a+I*u+U*p,B*n+F*h+I*d+U*m,B*s+F*l+I*g+U*E]},translate:function(t,e,i){return[1,0,0,0,0,1,0,0,0,0,1,0,t,e,i,1]},scale:function(t,e,i){return[t,0,0,0,0,e,0,0,0,0,i,0,0,0,0,1]},projection:function(t,e,i,r){const n=Math.tan(.5*e),s=i-r;return[1/(t*n),0,0,0,0,1/n,0,0,0,0,-(-i-r)/s,-1,0,0,2*r*i/s,0]},view:function(t,e,r){let n=this.identity(1);const s=i.normalize(i.add(e,i.multiply(t,-1))),o=i.normalize(i.cross(s,r)),a=i.cross(o,s);return n[0]=o[0],n[4]=o[1],n[8]=o[2],n[1]=a[0],n[5]=a[1],n[9]=a[2],n[2]=-s[0],n[6]=-s[1],n[10]=-s[2],n[12]=-i.dot(o,t),n[13]=-i.dot(a,t),n[14]=i.dot(s,t),n},rotate:function(t,e){if(0===e)return this.identity();let r=i.normalize(i.values(t));const n=Math.cos(e),s=Math.sin(e),o=1-n;return[n+Math.pow(r[0],2)*o,r[1]*r[0]*o+r[2]*s,r[2]*r[0]*o-r[1]*s,0,r[0]*r[1]*o-r[2]*s,n+Math.pow(r[1],2)*o,r[2]*r[1]*o-r[0]*s,0,r[0]*r[2]*o-r[1]*s,r[1]*r[2]*o-r[0]*s,n+Math.pow(r[2],2)*o,0,0,0,0,1]},log:function(t){let e="";for(let i=0;i<16;i++)e+=Math.round(1e3*t[i])/1e3+",\t",(i+1)%4==0&&(e+="\n");console.log(e)}};class n{constructor(t,e=[1,1,1],i=0,r=[0,1,0]){this.position=t,this.scale=e,this.rotationAngle=i,this.rotationAxis=r,this.update()}update(){let t=r.translate(this.position.x,this.position.y,this.position.z),e=r.rotate(this.axis,this.angle),i=r.scale(this.scale.x,this.scale.y,this.scale.z);this.model=r.multiply(r.multiply(t,e),i)}sendToShader(t){t.setMat4("model",this.model)}draw(t){}}class s{constructor(t,e=[0,0],i=[0,1,0]){this.position=t,this.uv=e,this.normal=i}toArray(){return Object.entries(this).map((t=>t[1])).reduce(((t,e)=>t.concat(e)))}}class o{constructor(t,e,i=[]){this.gl=t;let r=[];e.map((t=>r=r.concat(t.toArray()))),r=new Float32Array(r),this.vertexBuffer=t.createBuffer(),t.bindBuffer(t.ARRAY_BUFFER,this.vertexBuffer),t.bufferData(t.ARRAY_BUFFER,r,t.STATIC_DRAW),i.length%3&&console.warn("Mesh indices count cant be divided by 3 !"),this.indexed=Boolean(i.length),this.indexed?this.verticesCount=i.length:this.verticesCount=e.length,this.indexed&&(this.IndexBuffer=t.createBuffer(),t.bindBuffer(t.ELEMENT_ARRAY_BUFFER,this.IndexBuffer),t.bufferData(t.ELEMENT_ARRAY_BUFFER,new Uint16Array(i),t.STATIC_DRAW))}draw(t){const e=t.getAttribLocation("position"),i=t.getAttribLocation("uv"),r=t.getAttribLocation("normal");this.gl.bindBuffer(this.gl.ARRAY_BUFFER,this.vertexBuffer),this.gl.enableVertexAttribArray(e),this.gl.vertexAttribPointer(e,3,this.gl.FLOAT,!1,32,0),this.gl.enableVertexAttribArray(i),this.gl.vertexAttribPointer(i,2,this.gl.FLOAT,!1,32,12),this.gl.enableVertexAttribArray(r),this.gl.vertexAttribPointer(r,3,this.gl.FLOAT,!1,32,20),t.use(),this.indexed?(this.gl.bindBuffer(this.gl.ELEMENT_ARRAY_BUFFER,this.IndexBuffer),this.gl.drawElements(this.gl.TRIANGLES,this.verticesCount,this.gl.UNSIGNED_SHORT,0)):this.gl.drawArrays(this.gl.TRIANGLES,0,this.verticesCount)}}const a=function(t,e){return t.map((function(t){if(t.split(" ")[0]===e)return t})).filter((t=>Boolean(t)))},h=function(t,e){for(const i of t){const t=[];i.split(" ").forEach((function(e,i){const r=parseFloat(e);isNaN(r)||t.push(r)})),e.push(t)}},l=document.getElementsByTagName("canvas")[0];l.width=l.clientWidth,l.height=l.clientHeight;const c=l.getContext("webgl");c||console.error("failed to load webgl, it is possible that your browser do not support it !"),c.enable(c.DEPTH_TEST),c.depthFunc(c.LESS),c.enable(c.CULL_FACE);let u=new class{constructor(t,e,i){this.gl=t;let r=document.getElementById(e).text,n=document.getElementById(i).text,s=t.createShader(t.VERTEX_SHADER);if(t.shaderSource(s,r),t.compileShader(s),!t.getShaderParameter(s,t.COMPILE_STATUS))throw`Could not compile WebGL program. \n\n${t.getShaderInfoLog(s)}`;let o=t.createShader(t.FRAGMENT_SHADER);if(t.shaderSource(o,n),t.compileShader(o),!t.getShaderParameter(o,t.COMPILE_STATUS))throw`Could not compile WebGL program. \n\n${t.getShaderInfoLog(o)}`;if(this.program=t.createProgram(),t.attachShader(this.program,s),t.attachShader(this.program,o),t.linkProgram(this.program),!t.getProgramParameter(this.program,t.LINK_STATUS))throw`Could not compile WebGL program. \n\n${t.getProgramInfoLog(this.program)}`}use(){this.gl.useProgram(this.program)}getAttribLocation(t){return this.gl.getAttribLocation(this.program,t)}set(t,e){this.use(),"number"==typeof e?this.setFloat(t,e):"boolean"==typeof e?this.setInt(t,e):console.error(`the type: ${typeof e} , is not supported by shader.set() ! `)}setFloat(t,e){this.use(),this.gl.uniform1f(this.gl.getUniformLocation(this.program,t),e)}setInt(t,e){this.use(),this.gl.uniform1i(this.gl.getUniformLocation(this.program,t),e)}setBool(t,e){this.use(),this.setInt(t,e)}setMat4(t,e){this.use(),this.gl.uniformMatrix4fv(this.gl.getUniformLocation(this.program,t),!1,e)}}(c,"vertexShader","fragmentShader");u.use();let d=new class extends n{constructor(t,e,i,r,n=Math.PI/2,s=.1,o=100){super(t),this.yaw=e,this.pitch=i,this.aspect=r,this.fov=n,this.zNear=s,this.zFar=o,this.update()}update(){let t=[Math.cos(this.pitch)*Math.sin(this.yaw),Math.sin(this.pitch),Math.cos(this.pitch)*Math.cos(this.yaw)];t=i.multiply(this.position,-1),this.projection=r.projection(this.aspect,this.fov,this.zNear,this.zFar),this.view=r.view(this.position,i.add(this.position,t),[0,1,0])}sendToShader(t){t.setMat4("projection",this.projection),t.setMat4("view",this.view)}}([0,0,3],0,0,l.width/l.height,.5*Math.PI,.1,100);d.sendToShader(u);const g=new class{constructor(t,e){this.gl=t;const i=[],r=this;(async function(t){return await(await fetch(t)).text()})(e).then((function(n){const l=n.split("\n"),c=a(l,"v"),u=a(l,"vn"),d=a(l,"vt"),g=a(l,"f"),f=[];h(c,f);const p=[];h(u,p);const m=[];h(d,m),g.forEach((function(t){let r=t.split(" ").filter((t=>t.includes("/")));3!==r.length&&console.warn("file : ",e," has faces that aren't triangles !"),r=r.map((function(t){const e=t.split("/").map((t=>parseInt(t)));i.push(new s(f[e[0]-1],m[e[1]-1],p[e[2]-1]))}))})),r.mesh=new o(t,i)}))}draw(t){this.mesh&&this.mesh.draw(t)}}(c,"../../assets/logo.obj");new class{constructor(t,e){this.gl=t,this.id=t.createTexture(),t.bindTexture(t.TEXTURE_2D,this.id),t.texParameteri(t.TEXTURE_2D,t.TEXTURE_WRAP_S,t.CLAMP_TO_EDGE),t.texParameteri(t.TEXTURE_2D,t.TEXTURE_WRAP_T,t.CLAMP_TO_EDGE),t.texParameteri(t.TEXTURE_2D,t.TEXTURE_MIN_FILTER,t.LINEAR),this.width=1,this.height=1,this.img=new Image;const i=this;this.img.addEventListener("load",(function(){i.width=i.img.width,i.height=i.img.height,i.gl.bindTexture(t.TEXTURE_2D,i.id),i.gl.texImage2D(t.TEXTURE_2D,0,t.RGBA,t.RGBA,t.UNSIGNED_BYTE,i.img)})),this.img.src=e}bind(){this.gl.bindTexture(this.gl.TEXTURE_2D,this.id)}}(c,"../../assets/codechat.jpg");let f=[5,0,-5],p=[-.05,2,-.25],m=[0,0,0];const E=[0,-9.81,0];let T=.7,A=0;!function t(){if(g.mesh){m=i.add(E,i.multiply(p,-.5)),p=i.add(p,i.multiply(m,.01)),f=i.add(f,p),T*=.995,A+=T,f[1]<-20&&(f[1]=-20,p[1]*=-.95),c.viewport(0,0,l.width,l.height),c.clearColor(0,0,0,0),c.clear(c.COLOR_BUFFER_BIT|c.DEPTH_BUFFER_BIT);const t=r.translate(f[0],f[1],f[2]),e=r.rotate([0,1,0],A),n=r.identity(25);let s=r.multiply(r.multiply(t,e),n);u.setMat4("model",s),l.width=l.clientWidth,l.height=l.clientHeight,d.aspect=l.width/l.height,d.update(),d.sendToShader(u),g.draw(u)}requestAnimationFrame(t)}()})();