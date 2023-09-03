using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace ProducerKafka.ViewModels
{
    public class MessageKafkaViewModel
    {
        public string Message { get; set; }
        public string Topic { get; set; }
    }
}