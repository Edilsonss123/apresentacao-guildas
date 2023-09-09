using cliente_g_rpc.Protos;
using Grpc.Core;
using Grpc.Net.Client;
using static cliente_g_rpc.Protos.User;


namespace cliente_g_rpc.Services;

public class UserService
{
    private readonly GrpcChannel _channel;
    private readonly UserClient _client;

    public UserService()
    {
        Console.WriteLine("");
        var httpClientHandler = new HttpClientHandler();
        httpClientHandler.ServerCertificateCustomValidationCallback = 
            HttpClientHandler.DangerousAcceptAnyServerCertificateValidator;
        var httpClient = new HttpClient(httpClientHandler);

        AppContext.SetSwitch("System.Net.Http.SocketsHttpHandler.   Http2UnencryptedSupport", true);
        _channel = GrpcChannel.ForAddress("http://dotnet-server-g-rpc:5062",
        new GrpcChannelOptions { HttpClient = httpClient });

        _client =  new User.UserClient(_channel);
    }

    public IAsyncEnumerable<UserReply> NewUserStream(string name, string lastName)
    {
        var request = _client.NewUserStream(new NewUserRequest { 
            Name = name, LastName = lastName 
        });
        return request.ResponseStream.ReadAllAsync();
    }
}
