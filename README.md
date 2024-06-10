  <img src="https://github.com/OmerAti/jrodix-wp-speeder/blob/main/img/logo.png" alt="WP Speeder" width="50"> WP Speeder: WordPress Hızlandırma
WordPress, internet üzerindeki en popüler içerik yönetim sistemlerinden biridir. Ancak, birçok WordPress sitesi, yavaş yükleme süreleri nedeniyle kullanıcı deneyimini olumsuz etkileyebilir. Neyse ki, WordPress sitenizin hızını artırmak için birçok etkili yöntem mevcuttur. Bu projede, WordPress sitenizin performansını artırmak için bazı temel adımları ele aldık.

🚀 Adımlar
Sorgu Dizesi'ni Kaldır: WordPress sitenizin hızını artırmak için yapabileceğiniz ilk adımlardan biri, sorgu dizelerini kaldırmaktır. Sorgu dizeleri, tarayıcınızın sunucudan dosyaları alırken ekstra bilgi istemesine neden olabilir ve bu da yükleme süresini artırabilir.

Emojiyi Kaldır: WordPress'in son sürümleri, varsayılan olarak sitenize emoji ekler. Ancak, bu emoji dosyaları gereksiz veri transferine neden olabilir ve sitenizin yükleme süresini artırabilir.

JavaScript Ayrıştırmasını Ertele: JavaScript dosyaları, sayfa yüklendiğinde tarayıcı tarafından indirilir ve yürütülür. Ancak, JavaScript'in yüklenmesi ve yürütülmesi zaman alabilir ve sayfa yükleme süresini artırabilir.

Iframe Tembel Yükleme: Iframe'ler, sayfanın yüklenmesini geciktirebilir, özellikle de içeriği üçüncü taraf sitelerden alınıyorsa. İframe tembel yükleme tekniği, iframe içeriğini sayfanın geri kalanından bağımsız olarak yükler, böylece ana içerik hızlı bir şekilde yüklenebilir.

JS'yi ve CSS'yi Sıradan Çıkar: JavaScript ve CSS dosyalarınızı sıkıştırarak ve birleştirerek dosya boyutunu azaltabilirsiniz. Bu, sunucunun bu dosyaları indirmesi ve tarayıcının bu dosyaları işlemesi için gereken zamanı azaltabilir.

Resimleri WebP'ye Dönüştür (Yalnızca Yeni Yüklenenler): WebP formatı, JPEG ve PNG'ye kıyasla daha küçük dosya boyutları sağlayabilir. Ancak, eski tarayıcılar WebP formatını desteklemez. Bu nedenle, yalnızca yeni yüklenen resimleri WebP'ye dönüştürmek, sitenizin hızını artırabilirken geriye dönük uyumluluğu korur.

Resimler için Lazy Load: Lazy load tekniği, sayfa yüklendiğinde sadece görünür olan içeriği yükler ve kullanıcı aşağı doğru kaydırdıkça diğer içeriği yükler. Bu, sayfa yükleme süresini azaltabilir ve kullanıcı deneyimini iyileştirebilir.

HTML Sıkıştır: HTML dosyalarınızı sıkıştırarak, dosya boyutunu azaltabilir ve sitenizin yükleme süresini iyileştirebilirsiniz. Bu, sunucunun HTML dosyalarını daha hızlı bir şekilde indirmesini sağlayabilir.

Sayfa Önbelleği: WordPress sitenizin sayfalarını önbelleğe alarak, tekrarlayan ziyaretlerde sayfa yükleme süresini azaltabilirsiniz. Bu, sunucunun sayfa içeriğini yeniden oluşturmak yerine önbellekten almasını sağlar.

🔧 Kurulum

```markdown
Projeyi klonlayın veya indirin
   git clone https://github.com/OmerAti/jrodix-wp-speeder.git

Zip dosyasını indirin

WordPress Yönetici Paneli'ne gidin ve Eklentiler > Eklenti Yükle sayfasına gidin veya zip dosyasını wp-content\plugins çıkarın

'WP Speeder'
