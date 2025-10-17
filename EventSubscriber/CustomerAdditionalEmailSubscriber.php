<?php

namespace KimaiPlugin\InvoiceEmailerBundle\EventSubscriber;

use App\Entity\CustomerMeta;
use App\Event\CustomerMetaDefinitionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Email;

class CustomerAdditionalEmailSubscriber implements EventSubscriberInterface
{
    public const META_FIELD_NAME = 'invoice_additional_email';

    public static function getSubscribedEvents(): array
    {
        return [
            CustomerMetaDefinitionEvent::class => ['loadCustomerMeta', 200],
        ];
    }

    public function loadCustomerMeta(CustomerMetaDefinitionEvent $event): void
    {
        $entity = $event->getEntity();

        $field = new CustomerMeta();
        $field->setName(self::META_FIELD_NAME);
        $field->setLabel('invoice_additional_email');
        $field->setType(EmailType::class);
        $field->setIsVisible(true);
        $field->setConstraints([
            new Email([
                'message' => 'invoice_additional_email.validation',
            ]),
        ]);
        $field->setOptions([
            'help' => 'invoice_additional_email.help',
            'required' => false,
        ]);

        $entity->setMetaField($field);
    }
}
