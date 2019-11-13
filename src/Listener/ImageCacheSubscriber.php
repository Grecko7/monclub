<?php
namespace App\Listener;

use App\Entity\Joueur;
use App\Entity\Picture;
use App\Entity\Property;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ImageCacheSubscriber implements EventSubscriber
{
    /**
     * @var CacheManager
     */
    private $cacheManager;

    /**
     * @var UploaderHelper
     * @param CacheManager $cacheManager
     * @param UploaderHelper $uploaderHelper
     */
    private $uploaderHelper;

    public function __construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper)
    {
        $this->cacheManager = $cacheManager;
        $this->uploaderHelper = $uploaderHelper;
    }
    public function getSubscribedEvents()
    {
        // Les événements qui nous seront utiles
        return [
            'preRemove',
            'preUpdate'
        ];
    }

    // Méthode pour effacer le cache et ne pas stocker les images inutiles qui ralentirons les performances du site

    //  PreRemove se produit juste avant que l'EntityManager ne supprime une entité
    public function preRemove(LifecycleEventArgs $args) {
        // Nous nous assurons que la recherche que l'on fais correspont bien à ma classe "Joueur"
        // Nous n'aurons pas la seconde étape si le premier if n'est pas valider
        $entity = $args->getEntity();
        if (!$entity instanceof Picture) {
            return;
        }
        // Nous supprimons l'image de cache
        $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
    }

    // preUpdate se produit juste avant que l'EntityManager ne modifie une entité. 
    public function preUpdate(PreUpdateEventArgs $args) {
        $entity = $args->getEntity();
        if (!$entity instanceof Joueur) {
            return;
        }
        // Nous effaçons le cache encore une fois
        if ($entity->getImageFile() instanceof UploadedFile) {
            $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
        }
    }
}
