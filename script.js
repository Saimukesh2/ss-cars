/* =====================================================================================
   BMW M4 Ignition — key click -> real audio -> real FBX model, auto-rotating 360°,
   hover reveals mechanical parts detected from the model's own mesh names.
   Vanilla Three.js (r128) + GSAP.

   MODEL_URL and TEXTURE_PATH are defined in index.php (as PHP-configurable values)
   and injected into the page just before this file is loaded — see index.php.
   ===================================================================================== */

/* ---------------------------------------------------------------------
   CORE THREE.JS SETUP
--------------------------------------------------------------------- */
const canvas = document.getElementById('three-canvas');
const renderer = new THREE.WebGLRenderer({ canvas, antialias:true });
renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
renderer.setSize(window.innerWidth, window.innerHeight);
renderer.outputEncoding = THREE.sRGBEncoding;
renderer.toneMapping = THREE.ACESFilmicToneMapping;
renderer.toneMappingExposure = 1.15;
renderer.shadowMap.enabled = true;
renderer.shadowMap.type = THREE.PCFSoftShadowMap;

const scene = new THREE.Scene();
scene.fog = new THREE.FogExp2(0x05070B, 0.045);

const camera = new THREE.PerspectiveCamera(45, window.innerWidth/window.innerHeight, 0.1, 200);
camera.position.set(0, 1.4, 6.5);

const keyLight = new THREE.SpotLight(0x00cfff, 12, 30, Math.PI/6, 0.4, 1.2);
keyLight.position.set(4,6,4); keyLight.castShadow = true;
scene.add(keyLight);
const rimLight = new THREE.PointLight(0x1e90ff, 8, 20);
rimLight.position.set(-4,2,-3);
scene.add(rimLight);
const fillLight = new THREE.PointLight(0xffffff, 1.4, 15);
fillLight.position.set(0,1,4);
scene.add(fillLight);
const topLight = new THREE.DirectionalLight(0xbfe9ff, 1.1);
topLight.position.set(2,8,2);
scene.add(topLight);
const ambient = new THREE.AmbientLight(0x0a1622, 1.4);
scene.add(ambient);

const floor = new THREE.Mesh(new THREE.PlaneGeometry(80,80), new THREE.MeshStandardMaterial({color:0x03050a, metalness:0.9, roughness:0.25}));
floor.rotation.x = -Math.PI/2; floor.position.y = -1.8; floor.receiveShadow = true;
scene.add(floor);
const grid = new THREE.GridHelper(80,80,0x00cfff,0x061018);
grid.position.y = -1.79; grid.material.opacity = 0.06; grid.material.transparent = true;
scene.add(grid);

/* -- particles: dust + smoke -- */
function softSprite(){
  const c = document.createElement('canvas'); c.width=c.height=64;
  const cx = c.getContext('2d');
  const g = cx.createRadialGradient(32,32,0,32,32,32);
  g.addColorStop(0,'rgba(255,255,255,0.9)'); g.addColorStop(0.4,'rgba(0,207,255,0.35)'); g.addColorStop(1,'rgba(0,207,255,0)');
  cx.fillStyle = g; cx.fillRect(0,0,64,64);
  return new THREE.CanvasTexture(c);
}
const sprite = softSprite();

const DUST_N = 240;
const dustGeo = new THREE.BufferGeometry();
const dustPos = new Float32Array(DUST_N*3);
for(let i=0;i<DUST_N;i++){ dustPos[i*3]=(Math.random()-0.5)*30; dustPos[i*3+1]=Math.random()*10-1; dustPos[i*3+2]=(Math.random()-0.5)*30; }
dustGeo.setAttribute('position', new THREE.BufferAttribute(dustPos,3));
const dust = new THREE.Points(dustGeo, new THREE.PointsMaterial({size:0.045, map:sprite, transparent:true, opacity:0.5, depthWrite:false, blending:THREE.AdditiveBlending}));
scene.add(dust);

const SMOKE_N = 80;
const smokeGeo = new THREE.BufferGeometry();
const smokePos = new Float32Array(SMOKE_N*3);
const smokeVel = [];
for(let i=0;i<SMOKE_N;i++){
  smokePos[i*3]=(Math.random()-0.5)*4; smokePos[i*3+1]=Math.random()*2-1.6; smokePos[i*3+2]=-3+(Math.random()-0.5)*3;
  smokeVel.push({x:(Math.random()-0.5)*0.003, y:0.002+Math.random()*0.003, z:-0.004-Math.random()*0.004});
}
smokeGeo.setAttribute('position', new THREE.BufferAttribute(smokePos,3));
const smokeMat = new THREE.PointsMaterial({size:0.9, map:sprite, transparent:true, opacity:0.12, depthWrite:false, blending:THREE.AdditiveBlending, color:0x88c8ff});
const smoke = new THREE.Points(smokeGeo, smokeMat);
scene.add(smoke);

function animateParticles(){
  const dp = dustGeo.attributes.position.array;
  for(let i=0;i<DUST_N;i++){ dp[i*3+1]+=0.0015; if(dp[i*3+1]>9) dp[i*3+1]=-1; }
  dustGeo.attributes.position.needsUpdate = true;
  const sp = smokeGeo.attributes.position.array;
  for(let i=0;i<SMOKE_N;i++){
    sp[i*3]+=smokeVel[i].x; sp[i*3+1]+=smokeVel[i].y; sp[i*3+2]+=smokeVel[i].z;
    if(sp[i*3+1]>3){ sp[i*3+1]=-1.6; sp[i*3+2]=-3+(Math.random()-0.5)*3; sp[i*3]=(Math.random()-0.5)*4; }
  }
  smokeGeo.attributes.position.needsUpdate = true;
}

/* ---------------------------------------------------------------------
   THE KEY (procedural — the ignition prop, not the car itself)
--------------------------------------------------------------------- */
const keyGroup = new THREE.Group();
const keyMetal = new THREE.MeshStandardMaterial({color:0x111418, metalness:0.85, roughness:0.25});
const keyAccent = new THREE.MeshStandardMaterial({color:0x00cfff, metalness:0.6, roughness:0.3, emissive:0x00cfff, emissiveIntensity:0.35});
const keyChrome = new THREE.MeshStandardMaterial({color:0xdfefff, metalness:1, roughness:0.08});
const fobBody = new THREE.Mesh(new THREE.CylinderGeometry(0.62,0.62,0.16,48), keyMetal);
fobBody.rotation.x = Math.PI/2; fobBody.castShadow = true;
keyGroup.add(fobBody);
const ring = new THREE.Mesh(new THREE.TorusGeometry(0.34,0.03,16,48), keyChrome);
ring.position.z = 0.09; keyGroup.add(ring);
const ringCore = new THREE.Mesh(new THREE.CircleGeometry(0.3,48), new THREE.MeshStandardMaterial({color:0x0b3550, metalness:0.4, roughness:0.4, emissive:0x00cfff, emissiveIntensity:0.15}));
ringCore.position.z = 0.091; keyGroup.add(ringCore);
const strip = new THREE.Mesh(new THREE.BoxGeometry(0.06,1.0,0.03), keyAccent);
strip.position.set(0,0,0.1); keyGroup.add(strip);
const blade = new THREE.Mesh(new THREE.BoxGeometry(0.1,0.9,0.03), keyChrome);
blade.position.set(0,-1.0,0); keyGroup.add(blade);
[[-0.22,0.28],[0.22,0.28],[0,0.02]].forEach((p,idx)=>{
  const btn = new THREE.Mesh(new THREE.CylinderGeometry(0.08,0.08,0.05,24), idx===2?keyAccent:keyMetal);
  btn.rotation.x = Math.PI/2; btn.position.set(p[0], p[1]*-1+0.02, 0.1);
  keyGroup.add(btn);
});
keyGroup.scale.setScalar(1.5);
keyGroup.position.set(0,0.3,0);
scene.add(keyGroup);

/* ---------------------------------------------------------------------
   THE CAR — loaded from your real FBX model
--------------------------------------------------------------------- */
const carGroup = new THREE.Group(); // pivot used for the continuous 360° spin
carGroup.visible = false;
scene.add(carGroup);

let carModel = null;      // the loaded FBX root object
let carMeshes = [];       // flat list of { mesh, category, origMaterials:[{opacity,transparent,emissiveHex,emissiveIntensity}] }
let modelReady = false;

// Keyword rules used to classify each mesh by its own name. Order matters — first match wins.
// If your FBX's mesh names don't contain these words, edit the arrays below to match what
// the debug panel (press "D" after the car loads) shows you.
const PART_CATEGORIES = [
  ['engine',       ['engine','motor','block','cylinder']],
  ['turbo',        ['turbo']],
  ['transmission', ['trans','gearbox','clutch']],
  ['exhaust',      ['exhaust','muffler','manifold']],
  ['chassis',      ['chassis','frame','subframe']],
  ['suspension',   ['suspension','shock','strut','spring','coil']],
  ['brake',        ['brake','disc','caliper','rotor']],
  ['wheel',        ['wheel','tire','tyre','rim']],
  ['interior',     ['seat','interior','dash','console','steering']],
  ['battery',      ['battery']],
  ['fuel',         ['fuel','tank']],
];
function classify(name){
  const n = (name || '').toLowerCase();
  for(const [category, words] of PART_CATEGORIES){
    if(words.some(w=>n.includes(w))) return category;
  }
  return 'body'; // default: unmatched meshes are treated as exterior body/trim
}
function getMats(mesh){ return Array.isArray(mesh.material) ? mesh.material : [mesh.material]; }

const modelLoadingEl = document.getElementById('modelLoading');
const modelPctEl = document.getElementById('modelPct');
const modelWarningEl = document.getElementById('modelWarning');

function loadCarModel(onDone){
  modelLoadingEl.classList.add('show');
  const loader = new THREE.FBXLoader();
  loader.setResourcePath(TEXTURE_PATH);
  loader.load(
    MODEL_URL,
    (object)=>{
      carModel = object;

      // normalize scale/position: FBX export units vary a lot (cm/mm/m), so fit the
      // model to a known size and sit it on the floor, centered at the origin.
      const box = new THREE.Box3().setFromObject(object);
      const size = box.getSize(new THREE.Vector3());
      const maxDim = Math.max(size.x, size.y, size.z) || 1;
      const scale = 4.4 / maxDim;
      object.scale.setScalar(scale);

      const box2 = new THREE.Box3().setFromObject(object);
      const center2 = box2.getCenter(new THREE.Vector3());
      object.position.x -= center2.x;
      object.position.z -= center2.z;
      object.position.y -= box2.min.y;

      // classify every mesh and cache its original material state
      object.traverse(child=>{
        if(child.isMesh){
          child.castShadow = true;
          child.receiveShadow = true;
          const category = classify(child.name);
          const mats = getMats(child);
          mats.forEach(m=>{ if(m) m.side = THREE.DoubleSide; });
          carMeshes.push({
            mesh: child,
            category,
            origMaterials: mats.map(m=>({
              opacity: m && m.opacity !== undefined ? m.opacity : 1,
              transparent: !!(m && m.transparent),
              emissiveHex: m && m.emissive ? m.emissive.getHex() : null,
              emissiveIntensity: m && m.emissiveIntensity !== undefined ? m.emissiveIntensity : 1,
            }))
          });
        }
      });

      carGroup.add(object);
      modelReady = true;
      buildDebugPanel();
      buildLabels();
      modelLoadingEl.classList.remove('show');
      onDone && onDone();
    },
    (xhr)=>{
      if(xhr.lengthComputable){
        modelPctEl.textContent = Math.round((xhr.loaded/xhr.total)*100)+'%';
      }
    },
    (err)=>{
      console.error('FBX load failed:', err);
      modelLoadingEl.classList.remove('show');
      modelWarningEl.innerHTML = `Could not load <code>${MODEL_URL}</code>. Make sure this page is served over HTTP, that source/BMW_M4_2021_v1.fbx exists relative to index.php, and that your server is configured to serve .fbx as a static file (Apache/PHP hosts usually do this out of the box — see .htaccess).`;
      modelWarningEl.classList.add('show');
      onDone && onDone(); // still continue the flow, just without a model
    }
  );
}

/* ---------------------------------------------------------------------
   AUDIO — real engine.mp3 file
--------------------------------------------------------------------- */
const engineAudio = document.getElementById('engineAudio');
const audioWarning = document.getElementById('audioWarning');
let audioReady = true;
engineAudio.addEventListener('error', ()=>{
  audioReady = false;
  audioWarning.classList.add('show');
  setTimeout(()=>audioWarning.classList.remove('show'), 3500);
});

/* ---------------------------------------------------------------------
   MOUSE + RAYCAST
--------------------------------------------------------------------- */
const mouse = { x:0, y:0 };
window.addEventListener('mousemove', e=>{
  mouse.x = (e.clientX/window.innerWidth)*2-1;
  mouse.y = -(e.clientY/window.innerHeight)*2+1;
});
const raycaster = new THREE.Raycaster();

/* ---------------------------------------------------------------------
   IGNITION SEQUENCE
--------------------------------------------------------------------- */
let ignited = false;
// kick off the model download immediately in the background so it's ready by the time
// the ignition sequence finishes, instead of waiting until after the click.
loadCarModel();

function triggerIgnition(){
  if(ignited) return;
  ignited = true;

  const tl = gsap.timeline();
  tl.to(keyGroup.scale, { x:1.35,y:1.35,z:1.35, duration:0.12, ease:'power2.out' })
    .to(keyGroup.scale, { x:1.5,y:1.5,z:1.5, duration:0.25, ease:'elastic.out(1,0.4)' })
    .to('#hero-ui', { opacity:0, duration:0.5 }, '<');

  tl.call(()=>{
    engineAudio.currentTime = 0;
    const playPromise = engineAudio.play();
    if(playPromise) playPromise.catch(()=>{
      audioReady = false;
      audioWarning.classList.add('show');
      setTimeout(()=>audioWarning.classList.remove('show'), 3500);
    });

    gsap.to('#flash-overlay', { opacity:0.5, duration:0.08, repeat:6, yoyo:true, delay:0.1 });
    const shakeTl = gsap.timeline({ delay:0.1 });
    for(let i=0;i<40;i++){
      shakeTl.to(camera.position, { x:`+=${(Math.random()-0.5)*0.05}`, y:`+=${(Math.random()-0.5)*0.03}`, duration:0.08 });
    }
    gsap.to(camera.position, { z:'-=1.2', duration:3, delay:0.3, ease:'power2.inOut' });
    gsap.to(smokeMat, { opacity:0.28, duration:1, yoyo:true, repeat:9 });

    let fired = false;
    const goMain = ()=>{ if(fired) return; fired = true; transitionToMain(); };
    engineAudio.addEventListener('ended', goMain, { once:true });
    setTimeout(goMain, audioReady ? 11000 : 3200);
  });
}

canvas.addEventListener('click', (e)=>{
  if(carGroup.visible) return;
  raycaster.setFromCamera(mouse, camera);
  const hits = raycaster.intersectObject(keyGroup, true);
  if(hits.length) triggerIgnition();
});

function transitionToMain(){
  const tl = gsap.timeline();
  tl.to(keyGroup.scale, { x:0.01,y:0.01,z:0.01, duration:0.9, ease:'power2.in' })
    .to(keyGroup.position, { y:'+=1.5', duration:0.9, ease:'power2.in' }, '<')
    .call(()=>{
      keyGroup.visible = false;
      carGroup.visible = true;
      document.getElementById('main-ui').classList.add('visible');
      gsap.fromTo(carGroup.scale, { x:0.001,y:0.001,z:0.001 }, { x:1,y:1,z:1, duration:1.1, ease:'back.out(1.4)' });
    }, null, '>');
}

/* ---------------------------------------------------------------------
   HOVER — undress the body panels, highlight mechanical parts
--------------------------------------------------------------------- */
let naked = false;
function setNaked(state){
  if(naked === state || !modelReady) return;
  naked = state;

  carMeshes.forEach(entry=>{
    const mats = getMats(entry.mesh);
    mats.forEach((m, i)=>{
      if(!m) return;
      const orig = entry.origMaterials[i];
      if(entry.category === 'body'){
        m.transparent = true;
        gsap.to(m, { opacity: state ? 0.07 : orig.opacity, duration:0.6, ease:'power2.out',
          onUpdate:()=>{ m.needsUpdate = true; },
          onComplete:()=>{ if(!state) m.transparent = orig.transparent; } });
      } else {
        // mechanical parts: keep fully visible, add a glow highlight while exposed
        if(m.emissive){
          if(state) m.emissive.setHex(0x00cfff);
          gsap.to(m, { emissiveIntensity: state ? 0.55 : (orig.emissiveIntensity||0), duration:0.5,
            onComplete:()=>{ if(!state && orig.emissiveHex!==null) m.emissive.setHex(orig.emissiveHex); } });
        }
      }
    });
  });

  labelEls.forEach(l=> l.el.classList.toggle('show', state));
  document.getElementById('hoverHint').style.opacity = state ? 0 : 1;
}

canvas.addEventListener('mousemove', ()=>{
  if(!carGroup.visible || !modelReady) return;
  raycaster.setFromCamera(mouse, camera);
  const hits = raycaster.intersectObjects(carMeshes.map(e=>e.mesh));
  setNaked(hits.length > 0);
});
canvas.addEventListener('mouseleave', ()=> setNaked(false));

/* ---------------------------------------------------------------------
   LABELS — one per detected mechanical mesh, positioned at its world bbox center
--------------------------------------------------------------------- */
const labelLayer = document.getElementById('label-layer');
let labelEls = [];
function cleanName(n){
  return (n||'Part').replace(/[_\.]/g,' ').replace(/\d+$/,'').trim() || 'Part';
}
function buildLabels(){
  labelLayer.innerHTML = '';
  labelEls = [];
  const mechanical = carMeshes.filter(e=>e.category!=='body' && e.category!=='wheel');
  // cap label count so it doesn't get overwhelming if the model has hundreds of small parts
  mechanical.slice(0, 24).forEach(entry=>{
    const el = document.createElement('div');
    el.className = 'part-label';
    el.innerHTML = `<div class="label-dot"></div><div class="label-tag">${cleanName(entry.mesh.name)} · ${entry.category}</div>`;
    labelLayer.appendChild(el);
    labelEls.push({ el, mesh: entry.mesh });
  });
}
const tmpVec = new THREE.Vector3();
const tmpBox = new THREE.Box3();
function updateLabels(){
  if(!carGroup.visible || !naked) return;
  labelEls.forEach(l=>{
    tmpBox.setFromObject(l.mesh);
    tmpBox.getCenter(tmpVec);
    tmpVec.project(camera);
    const x = (tmpVec.x*0.5+0.5)*window.innerWidth;
    const y = (-tmpVec.y*0.5+0.5)*window.innerHeight;
    l.el.style.left = x+'px';
    l.el.style.top = y+'px';
  });
}

/* ---------------------------------------------------------------------
   DEBUG PANEL — shows detected categories so you can tune PART_CATEGORIES
--------------------------------------------------------------------- */
const debugPanel = document.getElementById('debugPanel');
function buildDebugPanel(){
  const list = document.getElementById('debugList');
  const counts = {};
  carMeshes.forEach(e=>{ counts[e.category] = (counts[e.category]||0)+1; });
  list.innerHTML = Object.entries(counts).map(([cat,n])=>
    `<div class="row"><span>${cat}</span><b>${n} mesh${n>1?'es':''}</b></div>`).join('') +
    `<div class="row" style="margin-top:6px; border-top:1px solid rgba(255,255,255,0.1); padding-top:6px;"><span>Total meshes</span><b>${carMeshes.length}</b></div>`;
  console.log('Detected FBX meshes:', carMeshes.map(e=>({ name:e.mesh.name, category:e.category })));
}
window.addEventListener('keydown', e=>{ if(e.key.toLowerCase()==='d') debugPanel.classList.toggle('show'); });

/* ---------------------------------------------------------------------
   RENDER LOOP
--------------------------------------------------------------------- */
const clock = new THREE.Clock();
function animate(){
  requestAnimationFrame(animate);
  const t = clock.getElapsedTime();

  if(!carGroup.visible){
    keyGroup.rotation.y = t*0.6;
    keyGroup.rotation.x = Math.sin(t*0.4)*0.08;
    camera.position.x += (mouse.x*0.6 - camera.position.x)*0.03;
    camera.position.y += (1.4 + mouse.y*0.3 - camera.position.y)*0.03;
    camera.lookAt(0,0.3,0);
  } else {
    carGroup.rotation.y += 0.006; // continuous 360° auto-rotation
    const targetCamPos = new THREE.Vector3(0, 3.0, 6.4);
    camera.position.lerp(targetCamPos, 0.03);
    camera.lookAt(0, 1.4, 0);
  }

  animateParticles();
  updateLabels();
  renderer.render(scene, camera);
}
animate();

window.addEventListener('resize', ()=>{
  camera.aspect = window.innerWidth/window.innerHeight;
  camera.updateProjectionMatrix();
  renderer.setSize(window.innerWidth, window.innerHeight);
});