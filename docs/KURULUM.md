# Akıllı Creative — Kurulum ve Yönetim Rehberi

## Tasarım dili: "360°" (1.2.0)
Bembeyaz zemin, derin siyah ve parlayan turuncu. Başlıklar çok kalın ve sıkı (Inter Tight), gövde metni Plus Jakarta Sans. Giriş ekranı afiş tarzındadır: büyük başlık (vurgulu kelimeler turuncu degrade), A yıldız logosu ve etrafında dönen ışıklı turuncu yörünge halkası, önünde laptop ve telefon maketi, onay işaretli üç madde, büyük turuncu "Projenizi konuşalım" butonu ve WhatsApp numarası.

**Laptop ve telefon ekranları:** Ana Sayfa → Hero bloğu → "Görsel" (laptop ekranı, 16:10 önerilir) ve "Telefon ekranı görseli" (9:19). Kendi sitelerinizden ekran görüntüleri koyabilirsiniz; demo görselleri Akıllı Creative'in kendi tanıtımını gösterir.

### Yapay zekâ görünürlüğü (AEO / GEO / LLM)
- **/llms.txt** ve **/llms-full.txt** otomatik oluşturulur (hizmetler, sayfalar, çalışmalar, blog; tam metin sürümü). İçerik değişince kendini yeniler.
- **Akıllı Creative → Ayarlar → Yapay zekâ (AEO / GEO):** firma özeti, doğrulanmış kısa bilgiler, llms.txt aç/kapat, model eğitimi botlarını (GPTBot, Google-Extended, CCBot, ClaudeBot…) robots.txt ile engelleme. Yanıt/arama botları engellenmez.
- **"Kısa cevap (AEO)" bloğu:** soru + 40–60 kelimelik net cevap + maddeler + son güncelleme tarihi. FAQPage yapılandırılmış verisine eklenir. AEO/GEO hizmet sayfasında örneği var.
- Organization şemasına hizmetleriniz `knowsAbout`, firma özeti `description` olarak eklenir.
- Yeni hizmet: **Dijital Büyüme → AEO / GEO — Yapay Zekâ Arama Optimizasyonu** (tam içerik). Hiçbir yerde yapay zekâ yanıtlarında yer alma garantisi verilmez.

**Önceki sürümden güncelliyorsanız:** iki ZIP'i yükleyip "Değiştir" deyin, sonra **Akıllı Creative → Kurulum** ekranında "Ana Sayfa ve Hakkımızda sayfalarını güncel demo düzeniyle yenile" kutusunu işaretleyip çalıştırın (eski içerik Revizyonlar'da kalır). Yeni AEO/GEO hizmet sayfası da bu adımda eklenir; ana menüye kendiniz eklemeniz gerekir (Görünüm → Menüler).

### Gerçek içeriklerinizi ekleme
- **Ekip fotoğrafları:** Ana Sayfa / Hakkımızda → "Ekip" bloğu → sağ panelden kişi ekleyin (fotoğraf, ad, görev) → "Bu bölümü sitede gizle" işaretini kaldırın.
- **Müşteri yorumları:** "Müşteri yorumları" bloğu → yorum, ad, unvan, fotoğraf → gizleme işaretini kaldırın. Yalnızca izinli, gerçek yorumları kullanın.
- **Rakamlar:** "Rakamlar" bloğu → değer (örn. 120+) ve açıklama → gizlemeyi kaldırın. Rakamlar ekrana gelince sayarak artar.
- **Görüşme günü:** "Görüşme günü seçici" bloğu sonraki iş günlerini listeler; seçilen gün teklif formunda dolu gelir, talep ekranında ve bildirim e-postasında görünür.
- **Giriş kartları:** Hero bloğu → "Yüzen kartlar" alanından görsel/başlık değiştirilebilir (ekip veya proje fotoğrafları).

Teslimat iki ZIP dosyasından oluşur (`dist/` klasörü):

| Dosya | İçerik |
|---|---|
| `akilli-creative.zip` | Tema: tasarım, şablonlar, efektler, Customizer ayarları |
| `akilli-core.zip` | Yardımcı eklenti: hizmetler, projeler, referanslar, talepler, Gutenberg blokları, SEO katmanı, demo kurulum |

İçerikler (hizmet, proje, referans, talep) eklentide tutulur; tema değişse de kaybolmaz.

## 1. Kurulum (5 dakika)

1. **Eklentiler → Yeni Ekle → Eklenti yükle** → `akilli-core.zip` → Etkinleştir.
2. **Görünüm → Temalar → Yeni ekle → Tema yükle** → `akilli-creative.zip` → Etkinleştir.
3. **Akıllı Creative → Kurulum** ekranında **Kurulumu başlat**. Oluşturulanlar:
   - 11 sayfa (Ana Sayfa, Hakkımızda, Hizmetlerimiz, Referanslarımız, Çalışmalarımız, Blog, Teklif Al, İletişim, Gizlilik, Çerez, KVKK)
   - 4 hizmet kategorisi + 24 alt hizmet sayfası (içerik, SSS ve meta başlık/açıklama taslaklarıyla)
   - 6 örnek proje ("Örnek çalışma" etiketli; müşteri, yorum veya sonuç uydurulmamıştır), 6 blog yazısı
   - 4 menü (ana menü + hizmetler mega menüsü, footer menüleri, yasal bağlantılar)
4. Tema ve eklentinin kurulum sırası önemli değildir (1.0.1 ile düzeltildi).
5. Kurulum **tekrar çalıştırılabilir**: aynı içerik varsa atlanır, hiçbir şey silinmez veya üzerine yazılmaz. WordPress'in düzenlenmemiş "Merhaba dünya" yazısı ve "Örnek sayfa" yalnızca taslağa alınır.
6. Kalıcı bağlantılar "Düz" ise otomatik olarak `/%postname%/` yapılır. Statik ana sayfa zaten ayarlıysa değiştirilmez.

**Daha önce hata aldıysanız:** Eklentiler sayfasında "Akıllı Creative Çekirdek"i silin, yeni `akilli-core.zip`'i yükleyip etkinleştirin. İçerik kaybı olmaz (henüz hiçbir şey oluşturulmamıştı).

Önerilen ek: güvenilir e-posta için bir SMTP eklentisi (ör. WP Mail SMTP).

## 2. Nerede ne yönetilir?

| Ne | Nerede |
|---|---|
| Logo, favicon | Görünüm → Özelleştir → Site Kimliği |
| Renkler (zemin, metin, buton, konyak vurgu, saten tonu), yazı tipleri, header butonu, footer metinleri, mobil alt çubuk | Görünüm → Özelleştir → Akıllı Creative tema ayarları |
| Efekt seviyesi (Tam / Hafif / Kapalı), WebGL, mobilde WebGL, imleç, sayfa geçişleri, ziyaretçi "Hareketi azalt" düğmesi | Özelleştir → Immersive efektler |
| Çerez şeridi, varsayılan paylaşım görseli | Özelleştir → Çerez bildirimi ve paylaşım |
| Menüler | Görünüm → Menüler (Hizmetlerimiz altındaki 2 seviyeli öğeler otomatik mega menü olur) |
| İletişim, adres, WhatsApp, sosyal medya | Akıllı Creative → Ayarlar → İletişim bilgileri |
| Form zorunlu alanları, bütçe seçenekleri, metinler, KVKK sayfası, spam ayarları | Akıllı Creative → Ayarlar → Teklif ve iletişim formları |
| Bildirim e-posta adresleri ve konu | Akıllı Creative → Ayarlar → Bildirimler |
| Hizmetler (kategori = üst öğesi olmayan hizmet) | Hizmetler menüsü; ikon/kısa ad sağ panelde, özet "Özet" alanında |
| Projeler, galeri, video, doğrulanmış sonuçlar | Projeler menüsü → "Proje bilgileri" ve "Proje galerisi" kutuları |
| Proje / referans sıralaması | Projeler → Sıralama, Referanslar → Sıralama (sürükle-bırak) |
| Referans logoları ve bağlantıları | Referanslar (logo = kapak görseli). Kayıt yoksa bölüm sitede hiç görünmez |
| Talepler | Talepler menüsü: durum, iç notlar, e-posta durumu, "Bildirimi tekrar gönder" |
| Sayfa başına meta başlık/açıklama | Her sayfanın altındaki "Arama motoru görünümü" kutusu |

### Ana sayfa ve sayfa bölümleri
Sayfalar Gutenberg ile düzenlenir. "Akıllı Creative" blok kategorisinde 17 blok vardır: Hero, Sayfa girişi, Kayan yazı bandı, Hizmet gezgini, Proje vitrini, Referans logoları, Süreç adımları, Özellik listesi, Kontrol listesi, SSS, Çağrı bandı, Manifesto metni, Görsel + metin, Blog yazıları, Rakamlar, İletişim bilgileri, Teklif formu.

- Bloğu seçin, içeriği **sağ paneldeki alanlardan** düzenleyin (başlık, metin, buton metni/bağlantısı, görsel, maddeler).
- **Sıra:** blokları yukarı/aşağı taşıyın. **Görünürlük:** Bölüm ayarları → "Bu bölümü sitede gizle" (içerik silinmez).
- Başlıkta `<em>kelime</em>` vurgulu kelime oluşturur. Hero başlığındaki `{kelime}`, "Dönen kelimeler" listesiyle değişir.
- **Rakamlar** bloğu ana sayfa ve Hakkımızda'da gizli ve boş gelir; yalnızca doğrulanmış rakamlarla doldurup görünür yapın.
- Hazır şablonlar: Ekle (+) → Desenler → Akıllı Creative (Hizmet sayfası iskeleti, Kapanış çağrı bandı, Proje vitrini).

### Teklif formu
Hizmet sayfalarındaki "Teklif al" bağlantıları `/teklif-al/?hizmet=<kısa-ad>` adresine gider; ilgili hizmet formda seçili gelir. Talepler önce veritabanına kaydedilir, sonra e-posta gönderilir; e-posta başarısız olursa talep kaybolmaz, panelde "Gönderilemedi" rozeti ve uyarı gösterilir. Spam koruması: gizli tuzak alanı, imzalı zaman damgası (minimum doldurma süresi) ve IP başına hız sınırı (IP saklanmaz). Önbellekli sayfalarda bozulmaması için nonce yerine bu yöntem kullanılır. Ayarlar → Gizlilik → Kişisel verileri dışa aktar/sil araçları talepleri de kapsar.

## 3. SEO

- Rank Math veya Yoast etkinse tema/eklenti **hiçbir** meta açıklama, Open Graph, canonical veya JSON-LD üretmez (çakışma olmaz). Kurulum, meta taslaklarını bu eklentilerin alanlarına da yazar.
- SEO eklentisi yoksa: sayfa bazlı başlık/açıklama, Open Graph, `ProfessionalService` (ana sayfa/iletişim/hakkımızda), `WebSite`, `BreadcrumbList`, `Service` (hizmetler), `CreativeWork` (projeler), `BlogPosting` (yazılar) ve SSS bloklarından `FAQPage` üretilir. Ana sayfa makale olarak işaretlenmez.
- Canonical WordPress çekirdeği tarafından üretilir.

### Yayına geçiş kontrol listesi
1. Örnek projeleri gerçek çalışmalarla değiştirin veya taslağa alın.
2. Referanslar menüsüne yalnızca izinli müşteri logolarını ekleyin.
3. Gizlilik, Çerez ve KVKK metinlerini hukuk danışmanınızla kesinleştirin (unvan, VERBİS vb.).
4. Bildirim adreslerini ayarlayıp bir test talebi gönderin; Talepler ekranında "Gönderildi" görün.
5. **Ayarlar → Okuma → "Arama motorlarının bu siteyi dizine eklemesini engelle"** işaretini kaldırın (demo kurulum bunu açar; panelde hatırlatma görünür).
6. Analiz/reklam aracı eklerseniz çerez şeridini ve Çerez Politikası'nı güncelleyin.

## 4. Performans ve erişilebilirlik notları
- Yazı tipleri sitenin kendi sunucusundan yüklenir; seçilen iki yazı tipi önceden yüklenir. Harici JS kütüphanesi yoktur.
- WebGL saten plakası (≈6 KB) yalnızca Hero bloğu olan sayfada, portföy filtresi yalnızca filtreli proje bloğunda, galeri/lightbox yalnızca proje detayında, form betiği yalnızca form olan sayfalarda yüklenir.
- WebGL telefonlarda varsayılan olarak kapalıdır (CSS alternatifi gösterilir), ekran dışında ve sekme arka plandayken durur.
- "Hareketi azalt" sistem tercihi veya footer düğmesi tüm animasyonları kapatır; JS kapalıyken menü (`#site-nav`), sekmeler, filtreler (sunucu tarafı) ve formlar çalışır.

## 5. Yapılan kontroller
WordPress 7.1.3 (PHP 8.3, SQLite) üzerinde:
- Tema/eklenti aktivasyonu, demo kurulum (80 öğe) ve tekrar kurulum (0 yeni, 55 atlandı — çoğaltma yok).
- 24 farklı URL türü 200 döndü; olmayan sayfa 404; PHP uyarısı yok.
- Formlar: hizmet ön seçimi, istemci + sunucu doğrulaması, JS'li ve JS'siz gönderim, honeypot, geçersiz token, `<script>` temizleme, e-posta başarısızlığında talebin korunması.
- Portföy filtreleri (kategori + hizmet, URL senkronu, boş durum, sunucu tarafı filtre).
- Mobil menü (odak tuzağı, Esc), masaüstü mega menü (klavye, Esc), sekmelerde ok tuşları.
- 360 px ve 1440 px'te yatay taşma yok; axe-core (WCAG 2 A/AA + best-practice) test edilen 12 sayfada ihlal yok.
- Blok editörü: 12 blok geçerli, canlı önizleme ve sağ panel alanları çalışıyor; Customizer, Talepler, Ayarlar, Sıralama ekranlarında JS hatası yok.
- Rank Math/Yoast simülasyonunda meta/JSON-LD çıktısının tamamen kapandığı doğrulandı.

### Bilinen sınırlamalar
- Gerçek Rank Math/Yoast eklentileriyle değil, algılama filtresiyle test edildi.
- Demo görselleri prosedürel olarak üretilmiş sunum panoları ve saten dokularıdır; gerçek proje görselleri ve fotoğraflarla değiştirilmelidir. Lüks hissin en büyük kaynağı gerçek, iyi çekilmiş fotoğraflar olacaktır.
- Hukuki metinler şablondur; hukuki danışmanlık yerine geçmez.
- Safari ve Firefox'ta görsel test yapılmadı (Chromium ile test edildi); View Transitions desteklemeyen tarayıcılarda geçişler animasyonsuz olur.
- Test ortamında e-posta sunucusu olmadığından başarılı gönderim değil, başarısızlık akışı doğrulandı.
