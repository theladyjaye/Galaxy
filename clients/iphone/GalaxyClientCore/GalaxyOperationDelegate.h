@class GalaxyOperation;
@protocol GalaxyOperationDelegate<NSObject>
-(void)operationDidFinish:(GalaxyOperation *)operation;
-(void)operationDidFailWithError:(NSError *)error; 
@end