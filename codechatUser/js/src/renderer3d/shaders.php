<script id="vertexShader" type="x-shader/x-vertex">
    attribute vec3 position;
    attribute vec2 uv;
    attribute vec3 normal;
    
    uniform mat4 model;
    uniform mat4 view;
    uniform mat4 projection;

    varying vec2 inUv;
    varying vec3 inNormal;
    varying vec3 fragPos;
 
    void main() {
        gl_Position = projection * view * model * vec4(position, 1);

        inUv = vec2(1.0 - uv.x, uv.y);
        inNormal = vec3(vec4(normal, 1) * model);
        fragPos = vec3(model * vec4(position, 1));
    }

</script>

<script id="fragmentShader" type="x-shader/x-fragment">

    precision mediump float;
    varying vec2 inUv;
    varying vec3 inNormal;
    varying vec3 fragPos;

    uniform sampler2D diffuseTexture;

    const vec3 sunDirection = normalize(vec3(.5, -.6, .7));

    void main() {
        vec3 color = vec3(texture2D(diffuseTexture,  inUv));

        //ambient light 
        float ambient = .3;

        //directional light calc
        vec3 normal = normalize(inNormal);
        float sun = dot(normal, -sunDirection) * 1.3;

        gl_FragColor = vec4(color * (max(sun, ambient)) , 1);
    }

</script>